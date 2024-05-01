<?php

namespace App\Repositories\Contracts;

use App\Models\Faq;
use App\Repositories\RepositoryContract;
use Illuminate\Database\Eloquent\Model;

interface IFaqRepository extends RepositoryContract
{
    public function create(array $data): Model|Faq;

    public function update($params);
}
