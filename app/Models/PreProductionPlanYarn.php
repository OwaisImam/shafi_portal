<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionPlanYarn extends Model
{
    use HasFactory;

    protected $fillable = [
        'percentage', 'yarn_purchase_order_id', 'pre_production_plan_id', 'kgs', 'qty',
    ];
}
