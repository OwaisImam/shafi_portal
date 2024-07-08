<?php

namespace App\Repositories;

use App\Models\KnittingProgram;
use App\Models\Mill;
use App\Models\YarnPurchaseOrder;

class KnittingProgramRepository extends BaseRepository
{
    public function model()
    {
        return KnittingProgram::class;
    }
}