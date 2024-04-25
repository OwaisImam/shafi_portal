<?php

namespace App\Repositories\Service;

use App\Constants\DefaultValues;
use App\Models\Service;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IServiceRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceRepository extends BaseRepository implements IServiceRepository
{
    public function model(): string
    {
        return Service::class;
    }

    public function getAllPaginated(): LengthAwarePaginator
    {
        return $this->model
            ->paginate(DefaultValues::PAGINATION_LIMIT);
    }

    public function selectByColumns(array $columns)
    {
        return $this->all($columns);
    }

    public function update($params)
    {
        if (isset($params['id'])) {
            return $this->model->updateOrCreate([
                'id' => $params['id'],
            ], $params);
        }

        return null;
    }

    // public function getByIds($ids)
    // {
    //     return $this->model->whereIn($ids)->get();
    // }

}
