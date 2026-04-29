<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportationVehicleOrderMatch extends Model
{
    use HasFactory;

    protected $table = 'transportation_vehicle_order_matches';

    protected $fillable = [
        'order_id',
        'provider_id',
        'transportation_vehicle_id',
        'price_per_day',
        'price_of_distance',
        'operator_price',
        'total_price',
        'status',
        'renter_accepted_at',
        'provider_accepted_at',
    ];

    public function order()
    {
        return $this->belongsTo(TransportationVehicleOrder::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class);
    }

    public function transportationVehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
