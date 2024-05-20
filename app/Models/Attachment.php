<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
         'upload_id', 'attachable_type', 'attachable_id',
    ];

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id');
    }

    public function attachable()
    {
        return $this->morphTo();
    }
}
