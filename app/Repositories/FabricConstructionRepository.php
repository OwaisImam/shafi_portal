<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\FabricConstruction;
use App\Models\Item;
use App\Models\Range;

class FabricConstructionRepository extends BaseRepository
{
    public function model()
    {
        return FabricConstruction::class;
    }

}
