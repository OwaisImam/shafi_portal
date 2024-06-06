<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dyeing extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'address', 'contact_person', 'contact', 'status'
    ];
}