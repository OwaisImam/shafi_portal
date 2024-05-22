<?php

namespace App\Repositories;

use App\Models\Departments;

class DepartmentRepository extends BaseRepository
{
    public function model()
    {
        return Departments::class;
    }
}
