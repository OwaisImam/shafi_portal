<?php

namespace App\Repositories\Menu;

use App\Models\Menu;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MenuRepository extends BaseRepository
{
    public function model(): string
    {
        return Menu::class;
    }

    public function truncate(): Model|Builder
    {
        return $this->model->truncate();
    }

    public function findByLabel(string $label): Menu|Model
    {
        return $this->model->where('label', $label)->first();
    }

    public function selectByColumns(array $columns)
    {
        return $this->orderBy('sort_order', 'asc')->all($columns);
    }
}
