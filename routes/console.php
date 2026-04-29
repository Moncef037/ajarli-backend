<?php

use App\Models\SuccessfullyRentedConstructionAttachment;
use App\Models\SuccessfullyRentedConstructionEquipment;
use App\Models\SuccessfullyRentedConstructionVehicle;
use App\Models\SuccessfullyRentedTransportationVehicle;
use App\Notifications\AttachmentActivityStatusChanged;
use App\Notifications\EquipmentActivityStatusChanged;
use App\Notifications\VehicleActivityStatusChanged;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $rentals = SuccessfullyRentedConstructionVehicle::where('renter_activity_status', 'in_work')->get();

    foreach ($rentals as $rental) {
        $endDate = Carbon::parse($rental->match->order->end_date);
        $provider = $rental->match->provider;
        $renter = $rental->match->order->renter;
        
        if (Carbon::now()->greaterThanOrEqualTo($endDate)) {
            $rental->update(['renter_activity_status' => 'completed']);
            $provider->notify(new VehicleActivityStatusChanged($rental->match->constructionVehicle, 'completed'));
            $renter->notify(new VehicleActivityStatusChanged($rental->match->constructionVehicle, 'completed'));
        }
    }

    return 0;
})->daily();

Schedule::call(function () {
    $rentals = SuccessfullyRentedConstructionEquipment::where('renter_activity_status', 'in_work')->get();

    foreach ($rentals as $rental) {
        $endDate = Carbon::parse($rental->match->order->end_date);
        $provider = $rental->match->provider;
        $renter = $rental->match->order->renter;
        
        if (Carbon::now()->greaterThanOrEqualTo($endDate)) {
            $rental->update(['renter_activity_status' => 'completed']);
            $provider->notify(new EquipmentActivityStatusChanged($rental->match->constructionEquipment, 'completed'));
            $renter->notify(new EquipmentActivityStatusChanged($rental->match->constructionEquipment, 'completed'));
        }
    }

    return 0;
})->daily();

Schedule::call(function () {
    $rentals = SuccessfullyRentedConstructionAttachment::where('renter_activity_status', 'in_work')->get();

    foreach ($rentals as $rental) {
        $endDate = Carbon::parse($rental->match->order->end_date);
        $provider = $rental->match->provider;
        $renter = $rental->match->order->renter;
        
        if (Carbon::now()->greaterThanOrEqualTo($endDate)) {
            $rental->update(['renter_activity_status' => 'completed']);
            $provider->notify(new AttachmentActivityStatusChanged($rental->match->constructionAttachment, 'completed'));
            $renter->notify(new AttachmentActivityStatusChanged($rental->match->constructionAttachment, 'completed'));
        }
    }

    return 0;
})->daily();

Schedule::call(function () {
    $rentals = SuccessfullyRentedTransportationVehicle::where('renter_activity_status', 'in_work')
        ->whereHas('match.order', function ($query) {
            $query->where('your_need', 'per_day');
        })
        ->get();

    foreach ($rentals as $rental) {
        $endDate = Carbon::parse($rental->match->order->end_date);
        $provider = $rental->match->provider;
        $renter = $rental->match->order->renter;
        
        if (Carbon::now()->greaterThanOrEqualTo($endDate)) {
            $rental->update(['renter_activity_status' => 'completed']);
            $provider->notify(new VehicleActivityStatusChanged($rental->match->transportationVehicle, 'completed'));
            $renter->notify(new VehicleActivityStatusChanged($rental->match->transportationVehicle, 'completed'));
        }
    }

    return 0;
})->daily();