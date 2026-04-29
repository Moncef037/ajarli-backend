<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionVehicleOrder extends Model
{
    use HasFactory;

    protected $table = 'construction_vehicle_orders';

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
        return $this->belongsTo(VehicleSubCategory::class);
    }

    public function photos()
    {
        return $this->hasMany(ConstructionVehicleOrderPhoto::class, 'order_id');
    }

    public function attachments()
    {
        return $this->hasMany(ConstructionVehicleOrderAttachment::class, 'order_id');
    }

    public function matches()
    {
        return $this->hasMany(ConstructionVehicleOrderMatch::class);
    }
}
