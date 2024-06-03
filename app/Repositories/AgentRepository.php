<?php

namespace App\Repositories;

use App\Models\Agent;
use App\Models\Mill;

class AgentRepository extends BaseRepository
{
    public function model()
    {
        return Agent::class;
    }
}