<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\ConstructionAttachmentOrder;
use App\Models\ConstructionAttachmentOrderMatch;
use App\Notifications\ConstructionAttachmentRentingRequestPlaced;
use App\Notifications\ConstructionAttachmentRentingRequestProviderFound;
use Illuminate\Http\Request;
use App\Rules\ValidVehicleAttachmentId;
use Carbon\Carbon;

class ConstructionAttachmentOrderController extends Controller
{
    // submit a renting order for a construction attachment
    public function submitOrder(Request $request)
    {
        $user = $request->user();
        $authenticatedUserType = $user->user_type;

        $fields = $request->validate([
            'sub_category_id' => ['required', 'exists:vehicle_sub_categories,id', new ValidVehicleAttachmentId],
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

        $targetAttachments = Attachment::where('approval_status', 'approved')
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

        if ($targetAttachments->isEmpty()) {
            return response()->json([
                'message' => 'No attachments were found for the given order',
            ], 404);
        } else {
            $date1 = Carbon::parse($fields['start_date']);
            $date2 = Carbon::parse($fields['end_date']);
    
            $daysDifference = $date1->diffInDays($date2);
    
            $order = ConstructionAttachmentOrder::create([
                'sub_category_id' => $fields['sub_category_id'],
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
                    $path = $photo->store('public/construction_attachment_orders/photos');
                    $order->photos()->create(['path' => $path]);
                }    
            }
    
            $matches = [];
        
            foreach ($targetAttachments as $attachment) {
                $attachmentOwner = $attachment->user;
    
                $priceOfService = $attachment->price_per_day * 0.05;
                $newPricePerDay = $attachment->price_per_day + $priceOfService;
                $priceOfDuration = ($attachment->price_per_day + $priceOfService) * $daysDifference;
                $transportPrice = $fields['transport'] === 'by_us' ? $attachment->transport_price : 0;

                $totalPrice = $priceOfDuration + $transportPrice;

                $match = ConstructionAttachmentOrderMatch::create([
                    'order_id' => $order->id,
                    'provider_id' => $attachmentOwner->id,
                    'construction_attachment_id' => $attachment->id,
                    'price_per_day' => $newPricePerDay,
                    'transport_price' => $transportPrice,
                    'total_price' => $totalPrice,
                ]);

                $matches[] = $match;

                $attachmentOwner->notify(new ConstructionAttachmentRentingRequestPlaced($match));

                $order->user->notify(new ConstructionAttachmentRentingRequestProviderFound($match));
            }
    
            return response()->json($matches, 200);
        }
    }
}
