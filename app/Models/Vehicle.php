<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'brand',
        'model',
        'year',
        'price_per_day',
        'price_per_month',
        'offer_type',
        'transport_price',
        'operator_price',
        'region',
        'city',
        'phone_number',
        'activity_status',
        'user_id',
        'approval_status',
    ];

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(VehicleSubCategory::class, 'sub_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(VehiclePhoto::class);
    }

    public function documents()
    {
        return $this->hasMany(VehicleDocument::class);
    }

    public function attachments()
    {
        return $this->hasMany(VehicleAttachment::class);
    }

    public function constructionVehicleOrderMatches()
    {
        return $this->hasMany(ConstructionVehicleOrderMatch::class);
    }

    public function transportationVehicleOrderMatches()
    {
        return $this->hasMany(TransportationVehicleOrderMatch::class);
    }

    public function successfullyRentedConstructionVehicle()
    {
        return $this->hasOneThrough(
            SuccessfullyRentedConstructionVehicle::class,
            ConstructionVehicleOrderMatch::class,
            'construction_vehicle_id',
            'match_id',
            'id',
            'id'
        );
    }

    public function successfullyRentedTransportationVehicle()
    {
        return $this->hasOneThrough(
            SuccessfullyRentedTransportationVehicle::class,
            TransportationVehicleOrderMatch::class,
            'transportation_vehicle_id',
            'match_id',
            'id',
            'id'
        );
    }

}
