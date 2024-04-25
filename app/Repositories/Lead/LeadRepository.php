<?php

namespace App\Repositories\Lead;

use App\Constants\DefaultValues;
use App\Models\Admin\Lead;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class LeadRepository extends BaseRepository
{
    public function model(): string
    {
        return Lead::class;
    }

    public function getAllPaginated(): LengthAwarePaginator
    {
        return $this->model->paginate(DefaultValues::PAGINATION_LIMIT);
    }
}
