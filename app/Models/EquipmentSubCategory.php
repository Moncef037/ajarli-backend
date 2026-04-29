<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentSubCategory extends Model
{
    use HasFactory;

    protected $table = 'equipment_sub_categories';

    protected $fillable = [
        'label',
        'value',
        'category_id',
        'photo'
    ];

    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }
}
