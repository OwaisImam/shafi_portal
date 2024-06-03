<?php

namespace App\Repositories;

use App\Models\Count;
use App\Models\Order;

class CountRepository extends BaseRepository
{
    public function model()
    {
        return Count::class;
    }
}