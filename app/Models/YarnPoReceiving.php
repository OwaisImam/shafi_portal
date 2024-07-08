<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YarnPoReceiving extends Model
{
    use HasFactory;

    protected $fillable = ['received_qty', 'yarn_po_id', 'received_by'];

    public function yarn_po()
    {
        return $this->belongsTo(YarnPurchaseOrder::class, 'yarn_po_id');
    }

    public function received_by()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}