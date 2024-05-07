<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\Country;
use App\Models\Departments;
use App\Models\Setting;

class DepartmentRepository extends BaseRepository
{
    public function model()
    {
        return Departments::class;
    }

}
