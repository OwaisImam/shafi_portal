<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YarnStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'yarn_purchase_order_id',
        'parent_stock_id',
        'total_qty',
        'received_qty',
        'remaining_qty',
        'cartage_slip_id',
        'delivery_from_type',
        'delivery_from_id',
        'delivery_to_type',
        'delivery_to_id',
        'type',
        'status',
        'remarks',
    ];

    public function cartage_slip()
    {
        return $this->belongsTo(CartageSlip::class);
    }

    public function parent_stock()
    {
        return $this->belongsTo(YarnStock::class, 'id', 'parent_stock_id');
    }

    public function yarn_purchase_order()
    {
        return $this->belongsTo(YarnPurchaseOrder::class);
    }
}
