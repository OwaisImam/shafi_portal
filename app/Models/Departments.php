<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'logo_id', 'slug'];

    public function logo()
    {
        return $this->belongsTo(Upload::class, 'logo_id', 'id');
    }
}
