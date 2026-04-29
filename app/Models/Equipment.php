<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $table = 'equipments';

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'brand',
        'model',
        'year',
        'price_per_day',
        'operator_price',
        'price_per_month',
        'offer_type',
        'transport_price',
        'region',
        'city',
        'phone_number',
        'activity_status',
        'user_id',
        'approval_status',
    ];

    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(EquipmentSubCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(EquipmentPhoto::class);
    }

    public function documents()
    {
        return $this->hasMany(EquipmentDocument::class);
    }

    public function constructionEquipmentOrderMatches()
    {
        return $this->hasMany(ConstructionEquipmentOrderMatch::class);
    }

    public function successfullyRentedConstructionEquipment()
    {
        return $this->hasOneThrough(
            SuccessfullyRentedConstructionEquipment::class,
            ConstructionEquipmentOrderMatch::class,
            'construction_equipment_id',
            'match_id',
            'id',
            'id'
        );
    }
}
