<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\ArticleStyle;
use App\Models\Item;
use App\Models\PurchaseOrder;

class ArticleStyleRepository extends BaseRepository
{
    public function model()
    {
        return ArticleStyle::class;
    }

}