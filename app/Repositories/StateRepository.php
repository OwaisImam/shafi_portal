<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\Setting;
use App\Models\State;

class StateRepository extends BaseRepository
{
    public function model()
    {
        return State::class;
    }
}
