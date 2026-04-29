<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessfullyRentedTransportationVehicle extends Model
{
    use HasFactory;
    protected $table = 'successfully_rented_transportation_vehicles';

    protected $fillable = [
        'match_id',
        'renter_activity_status',
    ];

    public function match()
    {
        return $this->belongsTo(TransportationVehicleOrderMatch::class);
    }

    public function getElapsedWorkdays()
    {
        $startDate = Carbon::parse($this->match->order->start_date);
        $endDate = Carbon::parse($this->match->order->end_date);
        $now = Carbon::now();

        if ($now->greaterThan($endDate)) {
            $now = $endDate;
        }

        return $startDate->diffInDays($now);
    }
}
