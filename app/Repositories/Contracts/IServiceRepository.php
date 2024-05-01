<?php

namespace App\Repositories\Contracts;

use App\Models\Service;
use App\Repositories\RepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface IServiceRepository extends RepositoryContract
{
    public function create(array $data): Model|Service;

    public function getAllPaginated(): LengthAwarePaginator;

    public function update($params);
}
