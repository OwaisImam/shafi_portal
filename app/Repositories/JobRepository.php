<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\Country;
use App\Models\Job;
use App\Models\Order;
use App\Models\Setting;

class JobRepository extends BaseRepository
{
    public function model()
    {
        return Job::class;
    }

}