<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportationVehicleOrderPhoto extends Model
{
    use HasFactory;
    protected $table = 'transportation_vehicle_order_photos';

    protected $fillable = [
        'order_id',
        'path',
    ];

    public function order()
    {
        return $this->belongsTo(TransportationVehicleOrder::class, 'order_id');
    }
}
