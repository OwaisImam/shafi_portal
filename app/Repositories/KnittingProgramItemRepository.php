<?php

namespace App\Repositories;

use App\Models\KnittingProgram;
use App\Models\KnittingProgramItem;
use App\Models\Mill;
use App\Models\YarnPurchaseOrder;

class KnittingProgramItemRepository extends BaseRepository
{
    public function model()
    {
        return KnittingProgramItem::class;
    }
}