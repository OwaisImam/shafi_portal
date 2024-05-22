<?php

namespace App\Repositories;

use App\Models\OrderItems;

class OrderItemRepository extends BaseRepository
{
    public function model()
    {
        return OrderItems::class;
    }
}
