<?php

namespace App\Repositories;

use App\Models\PreProductionPlan;

class PreProductionPlanRepository extends BaseRepository
{
    public function model()
    {
        return PreProductionPlan::class;
    }
}
