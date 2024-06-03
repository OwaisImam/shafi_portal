<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionPlanProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'process_id', 'pre_production_plan_id', 'status', 'notes',
    ];
}