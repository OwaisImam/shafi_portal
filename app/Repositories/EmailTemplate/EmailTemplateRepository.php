<?php

namespace App\Repositories\EmailTemplate;

use App\Constants\DefaultValues;
use App\Models\EmailTemplate as ModelsEmailTemplate;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IEmailTemplateRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class EmailTemplateRepository extends BaseRepository implements IEmailTemplateRepository
{
    public function model(): string
    {
        return ModelsEmailTemplate::class;
    }

    public function getAllPaginated(): LengthAwarePaginator
    {
        return $this->model->paginate(DefaultValues::PAGINATION_LIMIT);
    }
}
