<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartageSlip extends Model
{
    use HasFactory;

    protected $fillable = [
       'job_id',
       'slip_no',
       'delivery_from_type',
       'delivery_from_id',
       'delivery_to_type',
       'delivery_to_id',
       'driver_name',
       'driver_cell_no',
       'vehicle_no',
       'vehicle_type',
       'amount',
       'amount_in_words',
       'status',
       'upload_id',
    ];

    public function items()
    {
        return $this->hasMany(CartageSlipItem::class);
    }

    public function attachment()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

}