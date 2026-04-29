<?php

namespace App\Http\Controllers;

use App\Models\SuccessfullyRentedConstructionAttachment;
use Illuminate\Http\Request;

class SuccessfullyRentedConstructionAttachmentController extends Controller
{
    //get a successfully rented construction attachment by id
    public function getSuccessfullyRentedConstructionAttachmentById(Request $request, string $id)
    {
        $successfullyRentedConstructionAttachment = SuccessfullyRentedConstructionAttachment::with('match.order', 'match.order.photos', 'match.order.subCategory', 'match.constructionAttachment')->findOrFail($id);

        return response()->json($successfullyRentedConstructionAttachment);
    }

}
