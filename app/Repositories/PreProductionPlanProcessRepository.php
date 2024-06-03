<?php

namespace App\Repositories;

use App\Models\PreProductionPlanProcess;

class PreProductionPlanProcessRepository extends BaseRepository
{
    public function model()
    {
        return PreProductionPlanProcess::class;
    }
}
