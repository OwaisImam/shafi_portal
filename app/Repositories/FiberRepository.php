<?php

namespace App\Repositories;

use App\Models\Fiber;

class FiberRepository extends BaseRepository
{
    public function model()
    {
        return Fiber::class;
    }
}