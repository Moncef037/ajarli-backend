<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionEquipmentOrderMatch extends Model
{
    use HasFactory;
    protected $table = 'construction_equipment_order_matches';

    protected $fillable = [
        'order_id',
        'provider_id',
        'construction_equipment_id',
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
        return $this->belongsTo(ConstructionEquipmentOrder::class, 'order_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function constructionEquipment()
    {
        return $this->belongsTo(Equipment::class, 'construction_equipment_id');
    }
}
