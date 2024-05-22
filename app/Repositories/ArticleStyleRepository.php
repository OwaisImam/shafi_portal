<?php

namespace App\Repositories;

use App\Models\ArticleStyle;

class ArticleStyleRepository extends BaseRepository
{
    public function model()
    {
        return ArticleStyle::class;
    }
}
