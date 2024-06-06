<?php

namespace App\Repositories;

use App\Models\Fiber;
use App\Models\Knitting;

class KnittingRepository extends BaseRepository
{
    public function model()
    {
        return Knitting::class;
    }
}