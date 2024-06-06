<?php

namespace App\Repositories;

use App\Models\Dyeing;
use App\Models\Fiber;

class DyeingRepository extends BaseRepository
{
    public function model()
    {
        return Dyeing::class;
    }
}