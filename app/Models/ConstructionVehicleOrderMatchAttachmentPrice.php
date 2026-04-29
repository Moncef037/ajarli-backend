<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionVehicleOrderMatchAttachmentPrice extends Model
{
    use HasFactory;

    protected $table = 'construction_vehicle_order_match_attachment_prices';

    protected $fillable = [
        'match_id',
        'attachment_id',
        'price',
    ];

    public function match()
    {
        return $this->belongsTo(ConstructionVehicleOrderMatch::class, 'match_id');
    }

    public function attachment()
    {
        return $this->belongsTo(VehicleAttachment::class, 'attachment_id');
    }
}
