<?php

namespace App\Http\Controllers;

use App\Models\SuccessfullyRentedConstructionVehicle;
use Illuminate\Http\Request;

class SuccessfullyRentedConstructionVehicleController extends Controller
{
    // get a successfully rented construction vehicle by id
    public function getSuccessfullyRentedConstructionVehicleById(Request $request, string $id)
    {
        $successfullyRentedConstructionVehicles = SuccessfullyRentedConstructionVehicle::with('match.order', 'match.order.photos', 'match.order.subCategory', 'match.order.attachments', 'match.constructionVehicle', 'match.attachments')->findOrFail($id);

        return response()->json($successfullyRentedConstructionVehicles);
    }
}
