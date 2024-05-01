<?php

namespace App\Repositories\Contracts;

use App\Models\Plan;
use App\Repositories\RepositoryContract;
use Illuminate\Database\Eloquent\Model;

interface IPlanRepository extends RepositoryContract
{
    public function create(array $data): Model|Plan;

    public function update($params);
}
