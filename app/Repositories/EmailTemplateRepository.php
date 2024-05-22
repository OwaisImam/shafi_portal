<?php

namespace App\Repositories;

use App\Constants\DefaultValues;
use App\Models\EmailTemplate;
use Illuminate\Pagination\LengthAwarePaginator;

class EmailTemplateRepository extends BaseRepository
{
    public function model(): string
    {
        return EmailTemplate::class;
    }

    public function getAllPaginated(): LengthAwarePaginator
    {
        return $this->model->paginate(DefaultValues::PAGINATION_LIMIT);
    }
}
