<?php

namespace App\Repositories;

use App\Models\Country;

class CountryRepository extends BaseRepository
{
    public function model()
    {
        return Country::class;
    }
}
