<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\Item;

class ItemRepository extends BaseRepository
{
    public function model()
    {
        return Item::class;
    }

}