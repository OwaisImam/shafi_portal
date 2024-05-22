<?php

namespace App\Repositories;

use App\Models\Range;

class RangeRepository extends BaseRepository
{
    public function model()
    {
        return Range::class;
    }
}
