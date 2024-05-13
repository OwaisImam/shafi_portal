<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\Category;
use App\Models\Item;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return Category::class;
    }

}