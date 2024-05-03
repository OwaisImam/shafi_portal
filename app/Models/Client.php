<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'city_id', 'logo_id', 'email', 'address', 'postal_code', 'phone_number', 'website', 'status', 'type'
    ];

    public function logo()
    {
        return $this->belongsTo(Upload::class, 'logo_id', 'id');
    }
}
