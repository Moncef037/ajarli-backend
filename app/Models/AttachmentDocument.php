<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentDocument extends Model
{
    use HasFactory;
    protected $table = 'attachment_documents';
    
    protected $fillable = [
        'attachment_id',
        'path',
    ];

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
}
