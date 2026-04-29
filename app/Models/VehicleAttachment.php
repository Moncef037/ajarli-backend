<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleAttachment extends Model
{
    use HasFactory;

    protected $table = 'vehicle_attachments';

    protected $fillable = [
        'sub_category_id',
        'price',
        'vehicle_id',
    ];

    public function subCategory()
    {
        return $this->belongsTo(VehicleSubCategory::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
