<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentPhoto extends Model
{
    use HasFactory;

    protected $table = 'attachment_photos';
    
    protected $fillable = [
        'attachment_id',
        'path',
    ];

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
}
