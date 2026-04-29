<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionVehicleOrderMatch extends Model
{
    use HasFactory;

    protected $table = 'construction_vehicle_order_matches';

    protected $fillable = [
        'order_id',
        'provider_id',
        'construction_vehicle_id',
        'price_per_day',
        'operator_price',
        'transport_price',
        'total_price',
        'status',
        'renter_accepted_at',
        'provider_accepted_at',
    ];

    public function order()
    {
        return $this->belongsTo(ConstructionVehicleOrder::class, 'order_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function constructionVehicle()
    {
        return $this->belongsTo(Vehicle::class, 'construction_vehicle_id');
    }

    public function attachments()
    {
        return $this->hasMany(ConstructionVehicleOrderMatchAttachmentPrice::class, 'match_id');
    }
}
