<?php

namespace App\Repositories\Plan;

use App\Models\Plan;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IPlanRepository;
use Illuminate\Database\Eloquent\Model;

class PlanRepository extends BaseRepository implements IPlanRepository
{
    public function model(): string
    {
        return Plan::class;
    }

    public function getByName(string $name): ?Plan
    {
        return $this->model
            ->where('name', $name)
            ->first();
    }

    public function selectByColumns(array $columns)
    {
        return $this->all($columns);
    }

    public function updateById($id, array $data, array $options = []): Plan|Model
    {
        return parent::updateById($id, $data, $options);
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

    public function getByIds($ids)
    {
        return $this->model->whereIn($ids)->get();
    }
}
