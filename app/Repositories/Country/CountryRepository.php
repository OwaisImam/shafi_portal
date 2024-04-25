<?php

namespace App\Repositories\Country;

use App\Models\Country;
use App\Repositories\BaseRepository;

class CountryRepository extends BaseRepository
{
    public function model(): string
    {
        return Country::class;
    }

    public function selectByColumns(array $columns)
    {
        return $this->all($columns);
    }
}
