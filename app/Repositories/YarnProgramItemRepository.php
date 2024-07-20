<?php

namespace App\Repositories;

use App\Models\Mill;
use App\Models\YarnProgram;
use App\Models\YarnProgramItems;
use App\Models\YarnPurchaseOrder;

class YarnProgramItemRepository extends BaseRepository
{
    public function model()
    {
        return YarnProgramItems::class;
    }
}