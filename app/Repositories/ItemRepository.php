<?php

namespace App\Repositories;

use App\Models\Item;

class ItemRepository extends BaseRepository
{
    public function model()
    {
        return Item::class;
    }
}
