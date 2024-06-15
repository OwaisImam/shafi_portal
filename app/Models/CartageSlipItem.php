<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartageSlipItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cartage_slip_id', 'order_item_id'
    ];

    public function order_item()
    {
        return $this->belongsTo(OrderItems::class, 'order_item_id');
    }
}