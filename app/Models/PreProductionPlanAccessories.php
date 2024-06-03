<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionPlanAccessories extends Model
{
    use HasFactory;

    protected $fillable = [
        'pre_production_plan_id', 'item_id', 'qty', 'notes',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function pre_production_plan()
    {
        return $this->belongsTo(PreProductionPlan::class);
    }
}
