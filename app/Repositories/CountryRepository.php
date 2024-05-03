<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\Country;
use App\Models\Setting;

class CountryRepository extends BaseRepository
{
    public function model()
    {
        return Country::class;
    }

}
