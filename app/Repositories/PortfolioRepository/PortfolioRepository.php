<?php

namespace App\Repositories\PortfolioRepository;

use App\Models\Blogs;
use App\Models\Portfolio;
use App\Repositories\BaseRepository;

class PortfolioRepository extends BaseRepository
{
    public function model(): string
    {
        return Portfolio::class;
    }

    public function findByField(string $field, string $value): ?Blogs
    {
        return $this->model->where($field, $value)->first();
    }

    public function getPortfolio()
    {
        return $this->model->where('status', 1)->get();
    }

    public function selectByColumns(array $columns)
    {
        return $this->all($columns);
    }
}
