<?php

namespace App\Repositories\Contracts;

use App\Models\EmailTemplate;
use App\Repositories\RepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface IEmailTemplateRepository extends RepositoryContract
{
    public function create(array $data): Model|EmailTemplate;

    public function getAllPaginated(): LengthAwarePaginator;
}
