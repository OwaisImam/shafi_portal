<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'article_style_no', 'article_style_id', 'description', 'sizes', 'color', 'qty', 'unit'];
}
