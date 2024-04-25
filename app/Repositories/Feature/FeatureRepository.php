<?php

namespace App\Repositories\Feature;

use App\Models\Features;
use App\Models\Page;
use App\Repositories\BaseRepository;

class FeatureRepository extends BaseRepository
{
    public function model(): string
    {
        return Features::class;
    }

    public function findByTitle(string $title): ?Page
    {
        return $this->model->where('title', $title)->first();
    }

    public function selectByColumns(array $columns)
    {
        return $this->all($columns);
    }
}
