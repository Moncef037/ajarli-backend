<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportationVehicleOrder extends Model
{
    use HasFactory;
    protected $table = 'transportation_vehicle_orders';

    protected $fillable = [
        'sub_category_id',
        'operator',
        'capacity',
        'quantity',
        'equipments',
        'your_need',
        'departure_location',
        'arrival_location',
        'duration',
        'start_date',
        'end_date',
        'hour',
        'more_details',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(VehicleSubCategory::class);
    }

    public function photos()
    {
        return $this->hasMany(TransportationVehicleOrderPhoto::class, 'order_id');
    }

    public function matches()
    {
        return $this->hasMany(TransportationVehicleOrderMatch::class);
    }
}