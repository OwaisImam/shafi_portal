<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\City;
use App\Models\Setting;

class CityRepository extends BaseRepository
{
    public function model()
    {
        return City::class;
    }
}
