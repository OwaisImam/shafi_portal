<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'article_style_no', 'article_style_id', 'description', 'sizes', 'color', 'qty', 'unit', 'range_id', 'gsm'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function article()
    {
        return $this->belongsTo(ArticleStyle::class, 'article_style_id', 'id');
    }

    public function range()
    {
        return $this->belongsTo(Range::class, 'range_id');
    }
}