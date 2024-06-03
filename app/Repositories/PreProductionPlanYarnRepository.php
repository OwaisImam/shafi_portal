<?php

namespace App\Repositories;

use App\Models\PreProductionPlanYarn;

class PreProductionPlanYarnRepository extends BaseRepository
{
    public function model()
    {
        return PreProductionPlanYarn::class;
    }
}
