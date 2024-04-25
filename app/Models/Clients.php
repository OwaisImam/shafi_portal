<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'city_id',
            'state_id',
            'country_id',
            'website',
            'email',
            'second_email',
            'phone',
            'is_emailed',
            'is_called',
            'follow_up_call',
            'follow_up_date',
            'remarks',
            'created_by',
            'status',
            'postal_code',
            'address',
            'google_data',
            'is_from_google',
    ];
}