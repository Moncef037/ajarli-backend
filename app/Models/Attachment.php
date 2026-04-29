<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id',
        'brand',
        'model',
        'year',
        'price_per_day',
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
        return $this->hasMany(AttachmentPhoto::class);
    }

    public function documents()
    {
        return $this->hasMany(AttachmentDocument::class);
    }

    public function constructionAttachmentOrderMatches()
    {
        return $this->hasMany(ConstructionAttachmentOrderMatch::class, 'construction_attachment_id');
    }

    public function successfullyRentedConstructionAttachment()
    {
        return $this->hasOneThrough(
            SuccessfullyRentedConstructionAttachment::class,
            ConstructionAttachmentOrderMatch::class,
            'construction_attachment_id',
            'match_id',
            'id',
            'id'
        );
    }
}
