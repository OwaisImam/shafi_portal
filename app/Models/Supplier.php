<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'contact_person', 'contact_number', 'status', 'category_id', 'code'];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
