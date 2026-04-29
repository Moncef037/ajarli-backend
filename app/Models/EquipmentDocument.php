<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentDocument extends Model
{
    use HasFactory;

    protected $table = 'equipment_documents';
    
    protected $fillable = [
        'equipment_id',
        'path',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
