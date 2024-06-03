<?php

namespace App\Repositories;

use App\Models\Mill;

class MillRepository extends BaseRepository
{
    public function model()
    {
        return Mill::class;
    }
}