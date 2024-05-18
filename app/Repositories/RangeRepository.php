<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\Item;
use App\Models\Range;

class RangeRepository extends BaseRepository
{
    public function model()
    {
        return Range::class;
    }

}