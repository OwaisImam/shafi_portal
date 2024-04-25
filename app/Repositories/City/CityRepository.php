<?php

namespace App\Repositories\City;

use App\Models\City;
use App\Repositories\BaseRepository;

class CityRepository extends BaseRepository
{
    public function model(): string
    {
        return City::class;
    }
}
