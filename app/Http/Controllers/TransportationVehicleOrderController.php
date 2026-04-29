<?php

namespace App\Http\Controllers;

use App\Models\TransportationVehicleOrder;
use App\Models\TransportationVehicleOrderMatch;
use App\Models\Vehicle;
use App\Notifications\TransportationVehicleRentingRequestPlaced;
use App\Notifications\TransportationVehicleRentingRequestProviderFound;
use App\Rules\ValidTransportationVehicleSubCategoryId;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransportationVehicleOrderController extends Controller
{
    // submit a renting order for a transportation vehicle
    public function submitOrder(Request $request)
    {
        $user = $request->user();
        $authenticatedUserType = $user->user_type;

        $fields = $request->validate([
            'sub_category_id' => ['required', 'exists:vehicle_sub_categories,id', new ValidTransportationVehicleSubCategoryId],
            'operator' => ['required', 'boolean'],
            'capacity' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'equipments' => ['required', 'boolean'],
            'your_need' => ['required', 'in:per_day,per_distance'],
            'departure_location' => ['nullable', 'string'],
            'arrival_location' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'hour' => ['nullable', 'date_format:H:i'],
            'more_details' => ['required', 'string'],
            'photos' => ['nullable'],
            'photos.*' => ['image'],
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
            ], 200);
        } else {
            $daysDifference = null;

            if ($fields['your_need'] === 'per_distance') {
                $fields['start_date'] = null;
                $fields['end_date'] = null;
                $fields['hour'] = null;
            } else {
                $fields['departure_location'] = null;
                $fields['arrival_location'] = null;
                
                $date1 = Carbon::parse($fields['start_date']);
                $date2 = Carbon::parse($fields['end_date']);
        
                $daysDifference = $date1->diffInDays($date2);    
            }
    
            $order = TransportationVehicleOrder::create([
                'sub_category_id' => $fields['sub_category_id'],
                'operator' => $fields['operator'],
                'equipments' => $fields['equipments'],
                'capacity' => $fields['capacity'],
                'quantity' => $fields['quantity'],
                'your_need' => $fields['your_need'],
                'departure_location' => $fields['departure_location'],
                'arrival_location' => $fields['arrival_location'],
                'duration' => $daysDifference,
                'start_date' => $fields['start_date'],
                'end_date' => $fields['end_date'],
                'hour' => $fields['hour'],
                'more_details' => $fields['more_details'],
                'user_id' => $user->id,
            ]);
    
            if ($request->hasFile('photos')) {
                $photos = $request->file('photos');
    
                foreach ($photos as $photo) {
                    $path = $photo->store('public/transportation_vehicle_orders/photos');
                    $order->photos()->create(['path' => $path]);
                }    
            }
    
            $matches = [];
             
            foreach ($targetVehicles as $vehicle) {
                $vehicleOwner = $vehicle->user;

                $priceOfService = $vehicle->price_per_day * 0.05;
                $newPricePerDay = $vehicle->price_per_day + $priceOfService;
                $priceOfDuration = $fields['your_need'] === 'per_day' ? $newPricePerDay * $daysDifference : 0;
                $priceOfDistance = 0;
                $operatorPrice = $fields['operator'] ? $vehicle->operator_price : 0;

                $totalPrice = $priceOfDuration + $operatorPrice;

                $match = TransportationVehicleOrderMatch::create([
                    'order_id' => $order->id,
                    'provider_id' => $vehicleOwner->id,
                    'transportation_vehicle_id' => $vehicle->id,
                    'price_per_day' => $newPricePerDay,
                    'price_of_distance' => $priceOfDistance,
                    'operator_price' => $operatorPrice,
                    'total_price' => $totalPrice,
                ]);

                $matches[] = $match;

                $vehicleOwner->notify(new TransportationVehicleRentingRequestPlaced($match));

                $order->user->notify(new TransportationVehicleRentingRequestProviderFound($match));
            }
                
            return response()->json($matches, 200);
        }
    }
}
