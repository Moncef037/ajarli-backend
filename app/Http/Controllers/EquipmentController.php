<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    // submit a new equipment
    public function submitEquipment(Request $request)
    {
        //
        $user = $request->user();
        
        $fields = $request->validate([
            'category_id' => ['required', 'exists:equipment_categories,id'],
            'sub_category_id' => ['required', 'exists:equipment_sub_categories,id'],
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'year' => ['required', 'integer'],
            'price_per_day' => ['required', 'numeric'],
            'price_per_month' => ['required', 'numeric'],
            'offer_type' => ['required', 'in:fixed,negotiable'],
            'transport_price' => ['required', 'numeric'],
            'operator_price' => ['required', 'numeric'],
            'region' => ['required', 'string'],
            'city' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'photos' => ['required'],
            'photos.*' => ['image'],
            'documents' => ['required'],
            'documents.*' => ['file', 'mimes:pdf,doc,docx'],
        ]);

        $equipment = Equipment::create([
            'category_id' => $fields['category_id'],
            'sub_category_id' => $fields['sub_category_id'],
            'brand' => $fields['brand'],
            'model' => $fields['model'],
            'year' => $fields['year'],
            'price_per_day' => $fields['price_per_day'],
            'price_per_month' => $fields['price_per_month'],
            'offer_type' => $fields['offer_type'],
            'transport_price' => $fields['transport_price'],
            'operator_price' => $fields['operator_price'],
            'region' => $fields['region'],
            'city' => $fields['city'],
            'phone_number' => $fields['phone_number'],
            'activity_status' => 'active',
            'approval_status' => 'not_approved',
            'user_id' => $user->id,
        ]);

        $photos = $request->file('photos');

        foreach ($photos as $photo) {
            $path = $photo->store('public/equipments/photos');
            $equipment->photos()->create(['path' => $path]);
        }

        $documents = $request->file('documents');

        foreach ($documents as $document) {
            $path = $document->store('public/equipments/documents');
            $equipment->documents()->create(['path' => $path]);
        }
        
        return response()->json([
            'message' => 'Equipment submitted successfully',
            'equipment' => $equipment
        ], 201);
    }

    // show a single equipment
    public function showEquipment(string $id, Request $request)
    {
        //
        $user = $request->user();

        $equipment = Equipment::with(['category', 'subCategory', 'user', 'photos', 'documents'])->findOrFail($id);

        if ($user->id !== $equipment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json($equipment);
    }

    // edit activity status of a equipment
    public function editActivityStatusOfEquipment(string $id, Request $request)
    {
        //
        $user = $request->user();

        $equipment = Equipment::findOrFail($id);

        if ($user->id !== $equipment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $fields = $request->validate([
            'activity_status' => ['required', 'in:active,out_of_service']
        ]);

        if ($equipment->activity_status !== 'in_service') {
            $equipment->update(['activity_status' => $fields['activity_status']]);

            return response()->json([
                'message' => 'Activity status changed successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Cannot change activity status of equipment in service'
            ], 400);
        }
    }
}
