<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'customer_po_number', 'customer_id', 'job_id', 'gsm', 'po_receive_date', 'delivery_date', 'payment_term_id', 'range_id', 'fabric_construction_id', 'gsm', 'order_quantity', 'article_style_count'];

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'customer_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function payment_term()
    {
        return $this->belongsTo(PaymentTerms::class);
    }

    public function range()
    {
        return $this->belongsTo(Range::class);
    }

    public function fabric_construction()
    {
        return $this->belongsTo(FabricConstruction::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function yarn_purchase_order()
    {
        return $this->hasMany(YarnPurchaseOrder::class);
    }
}