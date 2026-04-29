<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Attachment;
use App\Rules\ValidNonAttachmentVehicleCategoryId;
use App\Rules\ValidNonAttachmentVehicleSubCategoryId;
use App\Rules\ValidVehicleAttachmentId;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // submit a new vehicle
    public function submitVehicle(Request $request)
    {
        //
        $user = $request->user();

        $fields = $request->validate([
            'category_id' => ['required', 'exists:vehicle_categories,id', new ValidNonAttachmentVehicleCategoryId],
            'sub_category_id' => ['required', 'exists:vehicle_sub_categories,id', new ValidNonAttachmentVehicleSubCategoryId],
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
            'attachments' => ['nullable', 'array'],
            'attachments.*.sub_category_id' => ['nullable', 'string', new ValidVehicleAttachmentId],
            'attachments.*.price' => ['nullable', 'numeric'],
        ]);

        $vehicle = Vehicle::create([
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
            $path = $photo->store('public/vehicles/photos');
            $vehicle->photos()->create(['path' => $path]);
        }

        $documents = $request->file('documents');

        foreach ($documents as $document) {
            $path = $document->store('public/vehicles/documents');
            $vehicle->documents()->create(['path' => $path]);
        }

        if ($request->has('attachments')) {
            $attachments = $request->input('attachments');

            foreach ($attachments as $attachment) {
                $vehicle->attachments()->create($attachment);

                Attachment::create([
                    'sub_category_id' => $attachment['sub_category_id'],
                    'price_per_day' => $attachment['price'],
                    'activity_status' => 'active',
                    'approval_status' => 'not_approved',
                    'user_id' => $user->id,
                ]);
            }            
        }
        
        return response()->json([
            'message' => 'Vehicle submitted successfully',
            'vehicle' => $vehicle           
        ], 201);
    }

    // show a single vehicle
    public function showVehicle(string $id, Request $request)
    {
        //
        $user = $request->user();

        $vehicle = Vehicle::with(['category', 'subCategory', 'user', 'photos', 'documents', 'attachments', 'attachments.subCategory'])->findOrFail($id);

        if ($user->id !== $vehicle->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        return response()->json($vehicle);
    }

    // edit activity status of a vehicle
    public function editActivityStatusOfVehicle(string $id, Request $request)
    {
        //
        $user = $request->user();

        $vehicle = Vehicle::findOrFail($id);

        if ($user->id !== $vehicle->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $fields = $request->validate([
            'activity_status' => ['required', 'in:active,out_of_service']
        ]);

        if ($vehicle->activity_status !== 'in_service') {
            $vehicle->update(['activity_status' => $fields['activity_status']]);

            return response()->json([
                'message' => 'Activity status changed successfully'
            ]);    
        } else {
            return response()->json([
                'message' => 'Vehicle is in service, cannot change activity status'
            ], 400);
        }
    }
}