<?php

namespace App\Repositories;

use App\Models\Country;
use App\Models\YarnPoReceiving;

class YarnPoReceivingRepository extends BaseRepository
{
    public function model()
    {
        return YarnPoReceiving::class;
    }


}