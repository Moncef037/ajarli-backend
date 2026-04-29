<?php

namespace App\Http\Controllers;

use App\Models\SuccessfullyRentedTransportationVehicle;
use App\Models\TransportationVehicleOrderMatch;
use App\Notifications\TransportationVehicleOrderMatchSettled;
use App\Notifications\TransportationVehicleRentingRequestAcceptedByProvider;
use App\Notifications\TransportationVehicleRentingRequestAcceptedByRenter;
use App\Notifications\TransportationVehicleRentingRequestCanceled;
use App\Notifications\TransportationVehicleRentingRequestNegotiatedByProvider;
use App\Notifications\TransportationVehicleRentingRequestNegotiatedByRenter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransportationVehicleOrderMatchController extends Controller
{
    // negotiate an offer
    public function negotiate(Request $request, string $id)
    {
        $match = TransportationVehicleOrderMatch::findOrFail($id);

        $isOfferNegotiable = $match->transportationVehicle->offer_type === 'negotiable';

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
            'equipments' => ['boolean'],
            'your_need' => ['in:per_day,per_distance'],
            'departure_location' => ['string'],
            'arrival_location' => ['string'],
            'start_date' => ['date'],
            'end_date' => ['date', 'after:start_date'],
            'hour' => ['date_format:H:i'],
            'more_details' => ['string'],
            'photos' => ['nullable'],
            'photos.*' => ['image'],
            'price_per_day' => ['numeric'],
            'price_of_distance' => ['numeric'],
            'operator_price' => ['numeric', 'required_if:operator,true'],
        ]);

        $daysDifference = null;

        if (isset($fields['your_need']) && $fields['your_need'] === 'per_distance') {
            $fields['start_date'] = null;
            $fields['end_date'] = null;
            $fields['hour'] = null;
            $daysDifference = null;
        } elseif (isset($fields['your_need']) && $fields['your_need'] === 'per_day') {
            $fields['departure_location'] = null;
            $fields['arrival_location'] = null;

            $date1 = isset($fields['start_date']) ? Carbon::parse($fields['start_date']) : Carbon::parse($match->order->start_date);
            $date2 = isset($fields['end_date']) ? Carbon::parse($fields['end_date']) : Carbon::parse($match->order->end_date);

            $daysDifference = $date1->diffInDays($date2);
        }

        $match->order->update([
            'operator' => $fields['operator'] ?? $match->order->operator,
            'equipments' => $fields['equipments'] ?? $match->order->equipments,
            'capacity' => $fields['capacity'] ?? $match->order->capacity,
            'quantity' => $fields['quantity'] ?? $match->order->quantity,
            'your_need' => $fields['your_need'] ?? $match->order->your_need,
            'departure_location' => $fields['departure_location'] ?? $match->order->departure_location,
            'arrival_location' => $fields['arrival_location'] ?? $match->order->arrival_location,
            // 'duration' => $daysDifference ?? $match->order->duration,
            'duration' => $daysDifference,
            'start_date' => $fields['start_date'] ?? $match->order->start_date,
            'end_date' => $fields['end_date'] ?? $match->order->end_date,
            'hour' => $fields['hour'] ?? $match->order->hour,
            'more_details' => $fields['more_details'] ?? $match->order->more_details,
        ]);

        if ($request->hasFile('photos')) {
            if ($match->order->photos()->exists()) {
                Storage::delete($match->order->photos->pluck('path')->toArray());
                $match->order->photos()->delete();
            }

            $photos = $request->file('photos');

            foreach ($photos as $photo) {
                $path = $photo->store('public/transportation_vehicle_orders/photos');
                $match->order->photos()->create(['path' => $path]);
            }
        }

        $priceOfService = 0;
        $newPricePerDay = $match->price_per_day;
        $priceOfServiceDistance = 0;
        $newPriceOfDistance = $match->price_of_distance;
        $priceOfDuration = $match->price_per_day * $match->duration;
        $operatorPrice = $match->operator_price;

        if (isset($fields['price_per_day'])) {
            $priceOfService = $fields['price_per_day'] * 0.05;
            $newPricePerDay = $fields['price_per_day'] + $priceOfService;
            $priceOfDuration = $newPricePerDay * ($daysDifference ?? $match->duration);
        }

        if (isset($fields['price_of_distance'])) {
            $priceOfServiceDistance = $fields['price_of_distance'] * 0.05;
            $newPriceOfDistance = $fields['price_of_distance'] + $priceOfServiceDistance;
        }

        if (isset($fields['operator'])) {
            $operatorPrice = $fields['operator_price'] ?? $match->operator_price;
        }

        $totalPrice = $priceOfDuration + $operatorPrice + $newPriceOfDistance;

        $match->update([
            'price_per_day' => $newPricePerDay,
            'price_of_distance' => $newPriceOfDistance,
            'operator_price' => $operatorPrice,
            'total_price' => $totalPrice,
            'status' => 'negotiation',
            'renter_accepted_at' => null,
            'provider_accepted_at' => null,
        ]);

        if ($user->id === $match->order->user_id) {
            $match->provider->notify(new TransportationVehicleRentingRequestNegotiatedByRenter($match));
        } elseif ($user->id === $match->provider_id) {
            $match->order->user->notify(new TransportationVehicleRentingRequestNegotiatedByProvider($match));
        }

        return response()->json([
            'message' => 'Offer has been negotiated',
            'match' => $match,
        ]);
    }

    // mark an order match as accepted
    public function accept(Request $request, string $id)
    {
        $match = TransportationVehicleOrderMatch::findOrFail($id);

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
            $match->provider->notify(new TransportationVehicleRentingRequestAcceptedByRenter($match));
        } elseif ($user->id === $match->provider_id) {
            $match->order->user->notify(new TransportationVehicleRentingRequestAcceptedByProvider($match));
        }

        return response()->json([
            'message' => 'Order match has been accepted',
            'match' => $match,
        ]);
    }

    // cancel an order match
    public function cancel(Request $request, string $id)
    {
        $match = TransportationVehicleOrderMatch::findOrFail($id);
        
        $user = $request->user();

        $provider_id = $match->provider_id;
        $renter_id = $match->order->user_id;

        $provider_name = $match->provider->first_name . " " . $match->provider->last_name;
        $renter_name = $match->order->user->first_name . " " . $match->order->user->last_name;

        $provider = $match->provider;
        $renter = $match->order->user;

        $match->delete();

        if ($user->id === $renter_id) {
            $provider->notify(new TransportationVehicleRentingRequestCanceled($renter_id, $renter_name));
        } elseif ($user->id === $provider_id) {
            $renter->notify(new TransportationVehicleRentingRequestCanceled($provider_id, $provider_name));
        }

        return response()->json([
            'message' => 'Order match has been cancelled',
            'match' => $match,
        ]);
    }

    // mark an order match as settled
    public function settle(string $id)
    {
        $match = TransportationVehicleOrderMatch::findOrFail($id);

        $match->transportationVehicle->update([
            'activity_status' => 'in_service',
        ]);

        $successfullyRentedTransportationVehicle = SuccessfullyRentedTransportationVehicle::create([
            'match_id' => $match->id,
            'renter_activity_status' => 'in_work',
        ]);

        $provider = $match->provider;
        $renter = $match->order->user;

        $provider->notify(new TransportationVehicleOrderMatchSettled($successfullyRentedTransportationVehicle));

        $renter->notify(new TransportationVehicleOrderMatchSettled($successfullyRentedTransportationVehicle));

        return response()->json([
            'message' => 'Order match has been settled',
            'match' => $match,
            'successfullyRentedTransportationVehicle' => $successfullyRentedTransportationVehicle,
        ]);
    }

    /**
     * Get transportation attachment order match by id
     * 
     * This endpoint retrieves a transportation attachment order match by its id.
     */
    public function getOrderMatchById(Request $request, string $id)
    {
        $match = TransportationVehicleOrderMatch::with('order', 'order.photos', 'order.subCategory', 'provider', 'transportationVehicle')->findOrFail($id);

        return response()->json($match);
    }
}
