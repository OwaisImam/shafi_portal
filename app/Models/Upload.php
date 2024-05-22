<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'file_original_name', 'file_name', 'upload_by', 'file_size', 'extension', 'type',
    ];

    protected $appends = [
        'image_path',
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getFileOriginalName(): string
    {
        return $this->file_original_name;
    }

    public function getFileName(): string
    {
        return $this->file_name;
    }

    public function getUploadBy(): int
    {
        return $this->upload_by;
    }

    public function getFileSize(): int
    {
        return $this->file_size;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    public function uploadBy()
    {
        return $this->belongsTo(User::class, 'upload_by');
    }

    public function getImagePathAttribute()
    {
        if ($this->getFileName() != null) {
            return Storage::url('uploads/' . $this->getFileName());
        }

        return asset('assets/images/team/team-1.png');
    }
}
