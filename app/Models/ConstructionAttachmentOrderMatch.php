<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionAttachmentOrderMatch extends Model
{
    use HasFactory;
    protected $table = 'construction_attachment_order_matches';

    protected $fillable = [
        'order_id',
        'provider_id',
        'construction_attachment_id',
        'price_per_day',
        'transport_price',
        'total_price',
        'status',
        'renter_accepted_at',
        'provider_accepted_at',
    ];

    public function order()
    {
        return $this->belongsTo(ConstructionAttachmentOrder::class, 'order_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function constructionAttachment()
    {
        return $this->belongsTo(Attachment::class, 'construction_attachment_id');
    }
}
