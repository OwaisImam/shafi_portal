<?php

namespace App\Repositories\BlogsRepository;

use App\Constants\DefaultValues;
use App\Models\Blogs;
use App\Repositories\BaseRepository;

class BlogsRepository extends BaseRepository
{
    public function model(): string
    {
        return Blogs::class;
    }

    public function findByField(string $field, string $value): ?Blogs
    {
        return $this->model->where($field, $value)->first();
    }

    public function getPopularBlogs()
    {
        return $this->model->orderBy('views', 'desc')->get();
    }

    public function selectByColumns(array $columns)
    {
        return $this->model->where('status', 1)->select($columns)->get();
    }

    public function getRecentBlogs()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    public function getByKeyword($keyword = null)
    {
        $stmt = $this->model;

        if ($keyword) {
            $stmt = $stmt->where('title', 'like', '%' . $keyword . '%');
        }
        $stmt = $stmt->where('status', 1)->orderBy('created_at', 'desc');

        return $stmt->paginate(DefaultValues::PAGINATION_LIMIT);
    }

    public function next($id)
    {
        return $this->model->where('id', '>', $id)->orderBy('id')->first();
    }

    public function previous($id)
    {
        return $this->model->where('id', '<', $id)->orderBy('id', 'desc')->first();
    }
}
