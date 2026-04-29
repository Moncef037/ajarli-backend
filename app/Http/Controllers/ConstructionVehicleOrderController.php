<?php

namespace App\Http\Controllers;

use App\Models\ConstructionVehicleOrder;
use App\Models\ConstructionVehicleOrderMatch;
use App\Models\Vehicle;
use App\Notifications\ConstructionVehicleRentingRequestPlaced;
use App\Notifications\ConstructionVehicleRentingRequestProviderFound;
use App\Rules\ValidConstructionVehicleSubCategoryId;
use App\Rules\ValidVehicleAttachmentId;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ConstructionVehicleOrderController extends Controller
{
    // submit a renting order for a construction vehicle
    public function submitOrder(Request $request)
    {
        $user = $request->user();
        $authenticatedUserType = $user->user_type;

        $fields = $request->validate([
            'sub_category_id' => ['required', 'exists:vehicle_sub_categories,id', new ValidConstructionVehicleSubCategoryId],
            'operator' => ['required', 'boolean'],
            'capacity' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'hour' => ['required', 'date_format:H:i'],
            'transport' => ['required', 'in:by_yourself,by_us'],
            'more_details' => ['required', 'string'],
            'photos' => ['nullable'],
            'photos.*' => ['image'],
            'attachments' => ['nullable', 'array'],
            'attachments.*.sub_category_id' => ['nullable', 'exists:vehicle_sub_categories,id', new ValidVehicleAttachmentId],
        ]);

        $targetVehicles = Vehicle::where('approval_status', 'approved')
            ->where('activity_status', 'active')
            ->where('sub_category_id', $fields['sub_category_id'])
            ->whereHas('user', function ($query) use ($authenticatedUserType) {
                $query->whereIn('user_type', ['provider_individual', 'provider_society']) // Ensure the user is a provider
                    ->where(function ($query) use ($authenticatedUserType) {
                        $query->where('receive_notifications_from', 'both')
                            ->orWhere('receive_notifications_from', $authenticatedUserType);
                    });
            })
            ->get();

        if ($targetVehicles->isEmpty()) {
            return response()->json([
                'message' => 'No vehicles were found for the given order',
            ], 404);
        } else {
            $date1 = Carbon::parse($fields['start_date']);
            $date2 = Carbon::parse($fields['end_date']);
    
            $daysDifference = $date1->diffInDays($date2);
    
            $order = ConstructionVehicleOrder::create([
                'sub_category_id' => $fields['sub_category_id'],
                'operator' => $fields['operator'],
                'capacity' => $fields['capacity'],
                'quantity' => $fields['quantity'],
                'duration' => $daysDifference,
                'start_date' => $fields['start_date'],
                'end_date' => $fields['end_date'],
                'hour' => $fields['hour'],
                'transport' => $fields['transport'],
                'more_details' => $fields['more_details'],
                'user_id' => $user->id,
            ]);
    
            if ($request->hasFile('photos')) {
                $photos = $request->file('photos');
    
                foreach ($photos as $photo) {
                    $path = $photo->store('public/construction_vehicle_orders/photos');
                    $order->photos()->create(['path' => $path]);
                }    
            }
    
            if ($request->has('attachments')) {
                foreach ($fields['attachments'] as $attachmentData) {
                    $order->attachments()->create($attachmentData);
                }
            }
        
            $matches = [];
    
            foreach ($targetVehicles as $vehicle) {
                $vehicleOwner = $vehicle->user;
    
                $priceOfService = $vehicle->price_per_day * 0.05;
                $newPricePerDay = $vehicle->price_per_day + $priceOfService;
                $priceOfDuration = $newPricePerDay * $daysDifference;
                $operatorPrice = $fields['operator'] ? $vehicle->operator_price : 0;
                $transportPrice = $fields['transport'] === 'by_us' ? $vehicle->transport_price : 0;

                $totalPrice = $priceOfDuration + $operatorPrice + $transportPrice;

                $match = ConstructionVehicleOrderMatch::create([
                    'order_id' => $order->id,
                    'provider_id' => $vehicleOwner->id,
                    'construction_vehicle_id' => $vehicle->id,
                    'price_per_day' => $newPricePerDay,
                    'operator_price' => $operatorPrice,
                    'transport_price' => $transportPrice,
                    'total_price' => $totalPrice,
                ]);

                $attachments = $vehicle->attachments;
                $totalAttachmentsPrice = 0;

                if ($attachments->isNotEmpty()) {
                    foreach ($attachments as $attachment) {
                        $attachmentPrice = $attachment->price;
                        $totalAttachmentsPrice += $attachmentPrice;

                        $match->attachments()->create([
                            'attachment_id' => $attachment->id,
                            'price' => $attachment->price,
                        ]);
                    }

                    $match->update(['total_price' => $totalPrice + $totalAttachmentsPrice]);
                }

                $matches[] = $match;
                
                $vehicleOwner->notify(new ConstructionVehicleRentingRequestPlaced($match));

                $order->user->notify(new ConstructionVehicleRentingRequestProviderFound($match));
            }
    
            return response()->json($matches, 200);
        }
    }
}