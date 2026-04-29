<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Rules\ValidVehicleAttachmentId;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    // submit a new attachment
    public function submitAttachment(Request $request)
    {
        //
        $user = $request->user();

        $fields = $request->validate([
            'sub_category_id' => ['required', new ValidVehicleAttachmentId],
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'year' => ['required', 'integer'],
            'price_per_day' => ['required', 'numeric'],
            'price_per_month' => ['required', 'numeric'],
            'offer_type' => ['required', 'in:fixed,negotiable'],
            'transport_price' => ['required', 'numeric'],
            'region' => ['required', 'string'],
            'city' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'photos' => ['required'],
            'photos.*' => ['image'],
            'documents' => ['required'],
            'documents.*' => ['file', 'mimes:pdf,doc,docx'],
        ]);

        $attachment = Attachment::create([
            'sub_category_id' => $fields['sub_category_id'],
            'brand' => $fields['brand'],
            'model' => $fields['model'],
            'year' => $fields['year'],
            'price_per_day' => $fields['price_per_day'],
            'price_per_month' => $fields['price_per_month'],
            'offer_type' => $fields['offer_type'],
            'transport_price' => $fields['transport_price'],
            'region' => $fields['region'],
            'city' => $fields['city'],
            'phone_number' => $fields['phone_number'],
            'activity_status' => 'active',
            'approval_status' => 'not_approved',
            'user_id' => $user->id,
        ]);

        $photos = $request->file('photos');

        foreach ($photos as $photo) {
            $path = $photo->store('public/attachments/photos');
            $attachment->photos()->create(['path' => $path]);
        }

        $documents = $request->file('documents');

        foreach ($documents as $document) {
            $path = $document->store('public/attachments/documents');
            $attachment->documents()->create(['path' => $path]);
        }
        
        return response()->json([
            'message' => 'Attachment submitted successfully',
            'attachment' => $attachment
        ], 201);
    }

    // show a single attachment
    public function showAttachment(string $id, Request $request)
    {
        //
        $user = $request->user();

        $attachment = Attachment::with(['subCategory', 'user', 'photos', 'documents'])->findOrFail($id);

        if ($user->id !== $attachment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json($attachment);
    }

    // edit activity status of a attachment
    public function editActivityStatusOfAttachment(string $id, Request $request)
    {
        //
        $user = $request->user();

        $attachment = Attachment::findOrFail($id);

        if ($user->id !== $attachment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $fields = $request->validate([
            'activity_status' => ['required', 'in:active,in_service,out_of_service']
        ]);

        if ($attachment->activity_status !== 'in_service') {
            $attachment->update(['activity_status' => $fields['activity_status']]);

            return response()->json([
                'message' => 'Activity status changed successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Cannot change activity status of attachment in service'
            ], 400);
        }
    }
}