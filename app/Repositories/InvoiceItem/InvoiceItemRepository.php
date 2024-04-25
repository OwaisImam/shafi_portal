<?php

namespace App\Repositories\InvoiceItem;

use App\Models\InvoiceItem;
use App\Repositories\BaseRepository;

class InvoiceItemRepository extends BaseRepository
{
    public function model(): string
    {
        return InvoiceItem::class;
    }

    public function deleteByColumn(string $column, int $id)
    {
        return $this->model->where($column, $id)->delete();
    }
}
