<?php

namespace App\Repositories\TestimonialRepository;

use App\Models\Testimonial;
use App\Repositories\BaseRepository;

class TestimonialRepository extends BaseRepository
{
    public function model(): string
    {
        return Testimonial::class;
    }

    public function selectByColumns(array $columns)
    {
        return $this->all($columns);
    }
}
