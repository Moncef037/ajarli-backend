<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConstructionEquipmentOrder;
use App\Models\ConstructionEquipmentOrderMatch;
use App\Models\Equipment;
use App\Notifications\ConstructionEquipmentRentingRequestPlaced;
use App\Notifications\ConstructionEquipmentRentingRequestProviderFound;
use Carbon\Carbon;

class ConstructionEquipmentOrderController extends Controller
{
    // submit a renting order for a construction equipment
    public function submitOrder(Request $request)
    {
        $user = $request->user();
        $authenticatedUserType = $user->user_type;

        $fields = $request->validate([
            'sub_category_id' => ['required', 'exists:equipment_sub_categories,id'],
            'operator' => ['required', 'boolean'],
            'capacity' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'hour' => ['required', 'date_format:H:i'],
            'transport' => ['required', 'in:by_yourself,by_us'],
            'more_details' => ['required', 'string'],
            'photos' => ['nullable'],
            'photos.*' => ['image'],
        ]);

        $targetEquipments = Equipment::where('approval_status', 'approved')
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

        if ($targetEquipments->isEmpty()) {
            return response()->json([
                'message' => 'No equipments were found for the given order',
            ], 404);
        } else {
            $date1 = Carbon::parse($fields['start_date']);
            $date2 = Carbon::parse($fields['end_date']);
    
            $daysDifference = $date1->diffInDays($date2);
    
            $order = ConstructionEquipmentOrder::create([
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
                    $path = $photo->store('public/construction_equipment_orders/photos');
                    $order->photos()->create(['path' => $path]);
                }    
            }
    
            $matches = [];
        
            foreach ($targetEquipments as $equipment) {
                $equipmentOwner = $equipment->user;
        
                $priceOfService = $equipment->price_per_day * 0.05;
                $newPricePerDay = $equipment->price_per_day + $priceOfService;
                $priceOfDuration = $newPricePerDay * $daysDifference;
                $operatorPrice = $fields['operator'] ? $equipment->operator_price : 0;
                $transportPrice = $fields['transport'] === 'by_us' ? $equipment->transport_price : 0;

                $totalPrice = $priceOfDuration + $operatorPrice + $transportPrice;

                $match = ConstructionEquipmentOrderMatch::create([
                    'order_id' => $order->id,
                    'provider_id' => $equipmentOwner->id,
                    'construction_equipment_id' => $equipment->id,
                    'price_per_day' => $newPricePerDay,
                    'operator_price' => $operatorPrice,
                    'transport_price' => $transportPrice,
                    'total_price' => $totalPrice,
                ]);

                $matches[] = $match;

                $equipmentOwner->notify(new ConstructionEquipmentRentingRequestPlaced($match));

                $order->user->notify(new ConstructionEquipmentRentingRequestProviderFound($match));
            }
    
            return response()->json($matches, 200);
        }
    }
}