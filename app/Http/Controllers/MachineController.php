<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\ConstructionAttachmentOrder;
use App\Models\ConstructionAttachmentOrderMatch;
use App\Models\ConstructionEquipmentOrder;
use App\Models\ConstructionEquipmentOrderMatch;
use App\Models\ConstructionVehicleOrder;
use App\Models\ConstructionVehicleOrderMatch;
use App\Models\Equipment;
use App\Models\SuccessfullyRentedConstructionAttachment;
use App\Models\SuccessfullyRentedConstructionEquipment;
use App\Models\SuccessfullyRentedConstructionVehicle;
use App\Models\SuccessfullyRentedTransportationVehicle;
use App\Models\TransportationVehicleOrder;
use App\Models\TransportationVehicleOrderMatch;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    // list all machines submitted by a provider
    public function providerMachines(Request $request)
    {
        $user = $request->user();

        $vehicles = Vehicle::with(['category', 'subCategory', 'user'])->where('user_id', $user->id)->get();

        $equipments = Equipment::with(['category', 'subCategory', 'user'])->where('user_id', $user->id)->get();

        $attachments = Attachment::with(['subCategory', 'user'])->where('user_id', $user->id)->get();

        return response()->json([
            'vehicles' => $vehicles,
            'equipments' => $equipments,
            'attachments' => $attachments,
        ]);
    }

    // list all machines successfully rented by a renter
    public function renterMachines(Request $request)
    {
        $user = $request->user();

        $constructionVehicleOrders = ConstructionVehicleOrder::where('user_id', $user->id)->pluck('id');

        $constructionVehicleOrderMatches = ConstructionVehicleOrderMatch::whereIn('order_id', $constructionVehicleOrders)->pluck('id');

        $successfullyRentedVehicles = SuccessfullyRentedConstructionVehicle::whereIn('match_id', $constructionVehicleOrderMatches)
            ->with(['match.order', 'match.provider', 'match.constructionVehicle', 'match.constructionVehicle.subCategory'])
            ->get();

        $constructionEquipmentOrders = ConstructionEquipmentOrder::where('user_id', $user->id)->pluck('id');

        $constructionEquipmentOrderMatches = ConstructionEquipmentOrderMatch::whereIn('order_id', $constructionEquipmentOrders)->pluck('id');

        $successfullyRentedEquipments = SuccessfullyRentedConstructionEquipment::whereIn('match_id', $constructionEquipmentOrderMatches)
            ->with(['match.order', 'match.provider', 'match.constructionEquipment', 'match.constructionEquipment.subCategory'])
            ->get();

        $constructionAttachmentOrders = ConstructionAttachmentOrder::where('user_id', $user->id)->pluck('id');

        $constructionAttachmentOrderMatches = ConstructionAttachmentOrderMatch::whereIn('order_id', $constructionAttachmentOrders)->pluck('id');

        $successfullyRentedAttachments = SuccessfullyRentedConstructionAttachment::whereIn('match_id', $constructionAttachmentOrderMatches)
            ->with(['match.order', 'match.provider', 'match.constructionAttachment', 'match.constructionAttachment.subCategory'])
            ->get();

        $transportationVehicleOrders = TransportationVehicleOrder::where('user_id', $user->id)->pluck('id');

        $transportationVehicleOrderMatches = TransportationVehicleOrderMatch::whereIn('order_id', $transportationVehicleOrders)->pluck('id');

        $successfullyRentedTransportationVehicles = SuccessfullyRentedTransportationVehicle::whereIn('match_id', $transportationVehicleOrderMatches)
            ->with(['match.order', 'match.provider', 'match.transportationVehicle', 'match.transportationVehicle.subCategory'])
            ->get();

        return response()->json([
            'vehicles' => $successfullyRentedVehicles,
            'equipments' => $successfullyRentedEquipments,
            'attachments' => $successfullyRentedAttachments,
            'transportation_vehicles' => $successfullyRentedTransportationVehicles,
        ]);
    }

    // change activity status of all machines submitted by a provider
    public function changeActivityStatus(Request $request)
    {
        $user = $request->user();

        $fields = $request->validate([
            'activity_status' => ['required', 'in:active,out_of_service']
        ]);

        $vehicles = $user->vehicles->where('activity_status', '!=', 'in_service');

        $equipments = $user->equipments->where('activity_status', '!=', 'in_service');

        $attachments = $user->attachments->where('activity_status', '!=', 'in_service');

        if ($vehicles->isEmpty() && $equipments->isEmpty() && $attachments->isEmpty()) {
            return response()->json(['message' => 'You have not submitted any machines'], 400);
        }

        if ($vehicles->isNotEmpty()) {
            foreach ($vehicles as $vehicle) {
                $vehicle->update(['activity_status' => $fields['activity_status']]);
            }
        }

        if ($equipments->isNotEmpty()) {
            foreach ($equipments as $equipment) {
                $equipment->update(['activity_status' => $fields['activity_status']]);
            }
        }

        if ($attachments->isNotEmpty()) {
            foreach ($attachments as $attachment) {
                $attachment->update(['activity_status' => $fields['activity_status']]);
            }
        }

        return response()->json([
            'message' => 'Activity status changed successfully'
        ]);
    }
}
