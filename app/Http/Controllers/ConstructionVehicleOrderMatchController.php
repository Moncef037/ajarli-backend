<?php

namespace App\Http\Controllers;

use App\Models\ConstructionVehicleOrderMatch;
use App\Models\SuccessfullyRentedConstructionVehicle;
use App\Notifications\ConstructionVehicleOrderMatchSettled;
use App\Notifications\ConstructionVehicleRentingRequestAcceptedByProvider;
use App\Notifications\ConstructionVehicleRentingRequestAcceptedByRenter;
use App\Notifications\ConstructionVehicleRentingRequestCanceled;
use App\Notifications\ConstructionVehicleRentingRequestNegotiatedByProvider;
use App\Notifications\ConstructionVehicleRentingRequestNegotiatedByRenter;
use App\Rules\ValidVehicleAttachmentId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ConstructionVehicleOrderMatchController extends Controller
{
    // negotiate an offer
    public function negotiate(Request $request, string $id)
    {
        $match = ConstructionVehicleOrderMatch::findOrFail($id);

        $isOfferNegotiable = $match->constructionVehicle->offer_type === 'negotiable';

        if (!$isOfferNegotiable) {
            return response()->json([
                'message' => 'Offer is not negotiable',
            ], 400);
        }

        $user = $request->user();

        if (!($user->id === $match->order->user_id || $user->id === $match->provider_id)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $fields = $request->validate([
            'operator' => ['boolean'],
            'capacity' => ['integer'],
            'quantity' => ['integer'],
            'start_date' => ['date'],
            'end_date' => ['date', 'after:start_date'],
            'hour' => ['date_format:H:i'],
            'transport' => ['in:by_yourself,by_us'],
            'more_details' => ['string'],
            'photos' => ['nullable'],
            'photos.*' => ['image'],
            'orderAttachments' => ['array'],
            'orderAttachments.*.sub_category_id' => ['exists:vehicle_sub_categories,id', new ValidVehicleAttachmentId],
            'attachments' => ['array'],
            'attachments.*.price' => ['numeric'],
            'price_per_day' => ['numeric'],
            'operator_price' => ['numeric', 'required_if:operator,true'],
            'transport_price' => ['numeric', 'required_if:transport,by_us'],
        ]);

        $date1 = isset($fields['start_date']) ? Carbon::parse($fields['start_date']) : Carbon::parse($match->order->start_date);
        $date2 = isset($fields['end_date']) ? Carbon::parse($fields['end_date']) : Carbon::parse($match->order->end_date);

        $daysDifference = $date1->diffInDays($date2);

        $match->order->update([
            'operator' => $fields['operator'] ?? $match->order->operator,
            'capacity' => $fields['capacity'] ?? $match->order->capacity,
            'quantity' => $fields['quantity'] ?? $match->order->quantity,
            // 'duration' => $daysDifference ?? $match->order->duration,
            'duration' => $daysDifference,
            'start_date' => $fields['start_date'] ?? $match->order->start_date,
            'end_date' => $fields['end_date'] ?? $match->order->end_date,
            'hour' => $fields['hour'] ?? $match->order->hour,
            'transport' => $fields['transport'] ?? $match->order->transport,
            'more_details' => $fields['more_details'] ?? $match->order->more_details,
        ]);

        if ($request->hasFile('photos')) {
            if ($match->order->photos()->exists()) {
                Storage::delete($match->order->photos->pluck('path')->toArray());
                $match->order->photos()->delete();
            }

            $photos = $request->file('photos');

            foreach ($photos as $photo) {
                $path = $photo->store('public/construction_vehicle_orders/photos');
                $match->order->photos()->create(['path' => $path]);
            }
        }

        if ($request->has('orderAttachments')) {
            if ($match->order->attachments()->exists()) {
                $match->order->attachments()->delete();
            }

            foreach ($fields['orderAttachments'] as $attachmentData) {
                $match->order->attachments()->create($attachmentData['sub_category_id']);
            }
        }

        if ($request->has('attachments')) {
            $matchAttachments = $match->attachments;
            $attachments = $request->input('attachments');

            foreach ($attachments as $index => $attachment) {
                if (isset($matchAttachments[$index])) {
                    $matchAttachments[$index]->price = $attachment['price'] ?? $matchAttachments[$index]->price;
                    $matchAttachments[$index]->save();
                }
            }
        }

        $priceOfService = 0;
        $newPricePerDay = $match->price_per_day;
        $priceOfDuration = $match->price_per_day * $match->duration;
        $operatorPrice = $match->operator_price;
        $transportPrice = $match->transport_price;

        if (isset($fields['price_per_day'])) {
            $priceOfService = $fields['price_per_day'] * 0.05;
            $newPricePerDay = $fields['price_per_day'] + $priceOfService;
            $priceOfDuration = $newPricePerDay * ($daysDifference ?? $match->duration);
        }

        if (isset($fields['operator'])) {
            $operatorPrice = $fields['operator_price'] ?? $match->operator_price;
        }

        if ($fields['transport'] === 'by_us' && isset($fields['transport_price'])) {
            $transportPrice = $fields['transport_price'];
        } else {
            $transportPrice = 0;
        }

        $totalPrice = $priceOfDuration + $operatorPrice + $transportPrice;

        $match->update([
            'price_per_day' => $newPricePerDay,
            'operator_price' => $operatorPrice,
            'transport_price' => $transportPrice,
            'total_price' => $totalPrice,
            'status' => 'negotiation',
            'renter_accepted_at' => null,
            'provider_accepted_at' => null,
        ]);

        if ($user->id === $match->order->user_id) {
            $match->provider->notify(new ConstructionVehicleRentingRequestNegotiatedByRenter($match));
        } elseif ($user->id === $match->provider_id) {
            $match->order->user->notify(new ConstructionVehicleRentingRequestNegotiatedByProvider($match));
        }

        return response()->json([
            'message' => 'Offer has been negotiated',
            'match' => $match,
        ]);
    }

    // mark an order match as accepted
    public function accept(Request $request, string $id)
    {
        $match = ConstructionVehicleOrderMatch::findOrFail($id);

        $user = $request->user();

        if (!($user->id === $match->order->user_id || $user->id === $match->provider_id)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        if ($user->id === $match->order->user_id) {
            // Renter accepted
            if ($match->status === 'negotiation') {
                // If negotiation occurred, reset provider's acceptance
                $match->provider_accepted_at = null;
            }
            $match->renter_accepted_at = now();
            $match->status = 'accepted_by_renter';
        } elseif ($user->id === $match->provider_id) {
            // Provider accepted
            if ($match->status === 'negotiation') {
                // Reset renter's acceptance after negotiation
                $match->renter_accepted_at = null;
            }
            $match->provider_accepted_at = now();
            $match->status = 'accepted_by_provider';
        }
        // Check if both parties accepted consecutively
        if ($match->renter_accepted_at && $match->provider_accepted_at) {
            // Both parties accepted, settle the deal
            $match->status = 'settled';
            // Notify both parties, etc.
            $this->settle($id);
        }

        $match->save();

        if ($user->id === $match->order->user_id) {
            $match->provider->notify(new ConstructionVehicleRentingRequestAcceptedByRenter($match));
        } elseif ($user->id === $match->provider_id) {
            $match->order->user->notify(new ConstructionVehicleRentingRequestAcceptedByProvider($match));
        }

        return response()->json([
            'message' => 'Order match has been accepted',
            'match' => $match,
        ]);
    }

    // cancel an order match
    public function cancel(Request $request, string $id)
    {
        $match = ConstructionVehicleOrderMatch::findOrFail($id);

        $user = $request->user();

        $provider_id = $match->provider_id;
        $renter_id = $match->order->user_id;

        $provider_name = $match->provider->first_name . " " . $match->provider->last_name;
        $renter_name = $match->order->user->first_name . " " . $match->order->user->last_name;

        $provider = $match->provider;
        $renter = $match->order->user;

        $match->delete();

        if ($user->id === $renter_id) {
            $provider->notify(new ConstructionVehicleRentingRequestCanceled($renter_id, $renter_name));
        } elseif ($user->id === $provider_id) {
            $renter->notify(new ConstructionVehicleRentingRequestCanceled($provider_id, $provider_name));
        }

        return response()->json([
            'message' => 'Order match has been cancelled',
            'match' => $match,
        ]);
    }

    // mark an order match as settled
    public function settle(string $id)
    {
        $match = ConstructionVehicleOrderMatch::findOrFail($id);

        $match->constructionVehicle->update([
            'activity_status' => 'in_service',
        ]);

        $successfullyRentedConstructionVehicle = SuccessfullyRentedConstructionVehicle::create([
            'match_id' => $match->id,
            'renter_activity_status' => 'in_work',
        ]);

        $provider = $match->provider;
        $renter = $match->order->user;

        $provider->notify(new ConstructionVehicleOrderMatchSettled($successfullyRentedConstructionVehicle));

        $renter->notify(new ConstructionVehicleOrderMatchSettled($successfullyRentedConstructionVehicle));

        return response()->json([
            'message' => 'Order match has been settled',
            'match' => $match,
            'successfullyRentedConstructionVehicle' => $successfullyRentedConstructionVehicle,
        ]);
    }

    /**
     * Get construction vehicle order match by id
     * 
     * This endpoint retrieves a construction vehicle order match by its id.
     */
    public function getOrderMatchById(Request $request, string $id)
    {
        $match = ConstructionVehicleOrderMatch::with('order', 'order.photos', 'order.subCategory', 'order.attachments', 'provider', 'constructionVehicle', 'attachments')->findOrFail($id);

        return response()->json($match);
    }
}
