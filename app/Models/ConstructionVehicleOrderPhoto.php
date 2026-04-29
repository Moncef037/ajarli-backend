<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionVehicleOrderPhoto extends Model
{
    use HasFactory;

    protected $table = 'construction_vehicle_order_photos';

    protected $fillable = [
        'order_id',
        'path',
    ];

    public function order()
    {
        return $this->belongsTo(ConstructionVehicleOrder::class, 'order_id');
    }
}
