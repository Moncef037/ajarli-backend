<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionEquipmentOrder extends Model
{
    use HasFactory;
    protected $table = 'construction_equipment_orders';

    protected $fillable = [
        'sub_category_id',
        'operator',
        'capacity',
        'quantity',
        'duration',
        'start_date',
        'end_date',
        'hour',
        'transport',
        'more_details',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(EquipmentSubCategory::class);
    }

    public function photos()
    {
        return $this->hasMany(ConstructionEquipmentOrderPhoto::class, 'order_id');
    }

    public function matches()
    {
        return $this->hasMany(ConstructionEquipmentOrderMatch::class, 'order_id');
    }
}
