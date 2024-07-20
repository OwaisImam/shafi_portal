<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YarnProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'name'
    ];

    public function items()
    {
        return $this->hasMany(YarnProgramItems::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
