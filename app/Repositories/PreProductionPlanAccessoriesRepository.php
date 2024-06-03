<?php

namespace App\Repositories;

use App\Models\PreProductionPlanAccessories;

class PreProductionPlanAccessoriesRepository extends BaseRepository
{
    public function model()
    {
        return PreProductionPlanAccessories::class;
    }
}
