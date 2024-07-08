<?php

namespace App\Repositories;

use App\Models\Mill;
use App\Models\YarnProgram;
use App\Models\YarnPurchaseOrder;

class YarnProgramRepository extends BaseRepository
{
    public function model()
    {
        return YarnProgram::class;
    }
}