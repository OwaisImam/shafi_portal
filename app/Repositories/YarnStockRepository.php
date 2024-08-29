<?php

namespace App\Repositories;

use App\Models\Mill;
use App\Models\YarnStock;

class YarnStockRepository extends BaseRepository
{
    public function model()
    {
        return YarnStock::class;
    }
}