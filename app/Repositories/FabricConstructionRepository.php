<?php

namespace App\Repositories;

use App\Models\FabricConstruction;

class FabricConstructionRepository extends BaseRepository
{
    public function model()
    {
        return FabricConstruction::class;
    }
}
