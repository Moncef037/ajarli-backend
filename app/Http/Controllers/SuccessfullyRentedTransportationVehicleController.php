<?php

namespace App\Http\Controllers;

use App\Models\SuccessfullyRentedTransportationVehicle;
use Illuminate\Http\Request;

class SuccessfullyRentedTransportationVehicleController extends Controller
{
    // get a successfully rented transportation vehicle by id
    public function getSuccessfullyRentedTransportationVehicleById(Request $request, string $id)
    {
        $successfullyRentedTransportationVehicles = SuccessfullyRentedTransportationVehicle::with('match.order', 'match.order.photos', 'match.order.subCategory', 'match.transportationVehicle')->findOrFail($id);

        return response()->json($successfullyRentedTransportationVehicles);
    }    
}
