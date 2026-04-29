<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionEquipmentOrderPhoto extends Model
{
    use HasFactory;
    protected $table = 'construction_equipment_order_photos';

    protected $fillable = [
        'order_id',
        'path',
    ];

    public function order()
    {
        return $this->belongsTo(ConstructionEquipmentOrder::class, 'order_id');
    }
}