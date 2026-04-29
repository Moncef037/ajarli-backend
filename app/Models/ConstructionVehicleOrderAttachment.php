<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionVehicleOrderAttachment extends Model
{
    use HasFactory;

    protected $table = 'construction_vehicle_order_attachments';

    protected $fillable = [
        'sub_category_id',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(ConstructionVehicleOrder::class, 'order_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(VehicleSubCategory::class);
    }
}
