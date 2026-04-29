<?php

namespace App\Http\Controllers;

use App\Models\SuccessfullyRentedConstructionEquipment;
use Illuminate\Http\Request;

class SuccessfullyRentedConstructionEquipmentController extends Controller
{
    // get a successfully rented construction equipment by id
    public function getSuccessfullyRentedConstructionEquipmentById(Request $request, string $id)
    {
        $successfullyRentedConstructionEquipment = SuccessfullyRentedConstructionEquipment::with('match.order', 'match.order.photos', 'match.order.subCategory', 'match.constructionEquipment')->findOrFail($id);

        return response()->json($successfullyRentedConstructionEquipment);
    }
}
