<?php

namespace App\Repositories;

use App\Models\State;

class StateRepository extends BaseRepository
{
    public function model()
    {
        return State::class;
    }
}
