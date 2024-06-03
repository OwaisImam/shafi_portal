<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function accessories()
    {
        return $this->hasMany(PreProductionPlanAccessories::class);
    }

    public function processes()
    {
        return $this->hasMany(PreProductionPlanProcess::class);
    }

    public function yarn_purchase_orders()
    {
        return $this->hasMany(PreProductionPlanYarn::class);
    }
}