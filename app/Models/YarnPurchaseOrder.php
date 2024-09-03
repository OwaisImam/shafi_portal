<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YarnPurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
         'count_id',
         'fiber_id',
         'mill_id',
         'fabric_construction_id',
         'terms_of_delivery_id',
         'agent_id',
         'lbs',
         'kgs',
         'qty',
         'unit',
         'price_per_lb',
         'amount',
         'with_gst',
         'date_of_purchase',
         'terms_of_payment',
         'contract_no',
         'job_id',
         'remarks',
         'delivery_date',
         'completion_in',
         'order_id',
         'invoice_of',
         'remaining_qty',
     ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function fiber()
    {
        return $this->belongsTo(Fiber::class);
    }

    public function count()
    {
        return $this->belongsTo(Count::class);
    }

    public function fabric_construction()
    {
        return $this->belongsTo(FabricConstruction::class);
    }

    public function terms_of_delivery()
    {
        return $this->belongsTo(TermsOfDelivery::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function mill()
    {
        return $this->belongsTo(Mill::class);
    }

    public function receiving()
    {
        return $this->hasOne(YarnPoReceiving::class, 'yarn_po_id', 'id');
    }

}