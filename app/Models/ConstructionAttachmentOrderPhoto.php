<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionAttachmentOrderPhoto extends Model
{
    use HasFactory;
    protected $table = 'construction_attachment_order_photos';

    protected $fillable = [
        'order_id',
        'path',
    ];

    public function order()
    {
        return $this->belongsTo(ConstructionAttachmentOrder::class, 'order_id');
    }
}
