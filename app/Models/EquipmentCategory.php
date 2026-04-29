<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentCategory extends Model
{
    use HasFactory;

    protected $table = 'equipment_categories';

    protected $fillable = [
        'label',
        'value',
    ];

    public function subCategories()
    {
        return $this->hasMany(EquipmentSubCategory::class, 'category_id');
    }
}
