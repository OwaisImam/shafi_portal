<?php

namespace App\Repositories\OrderRelease;

use App\Models\OrderRelease;
use App\Repositories\BaseRepository;

class OrderReleaseRepository extends BaseRepository
{
    public function model(): string
    {
        return OrderRelease::class;
    }
}
