<?php

namespace App\Repositories\Page;

use App\Models\Page;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PageRepository extends BaseRepository
{
    public function model(): string
    {
        return Page::class;
    }

    public function truncate(): Model|Builder
    {
        return $this->model->truncate();
    }

    public function findByLabel(string $label): ?Page
    {
        return $this->model->where('label', $label)->first();
    }
}
