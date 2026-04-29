<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{
    use HasFactory;

    protected $table = 'vehicle_categories';

    protected $fillable = [
        'label',
        'value',
    ];

    public function subCategories()
    {
        return $this->hasMany(VehicleSubCategory::class, 'category_id');
    }
}
