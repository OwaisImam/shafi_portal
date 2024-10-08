<?php

namespace App\Repositories;

/**
 * Contacts RepositoryContract.
 */
interface RepositoryContract
{
    public function all(array $columns = ['*']);

    public function count();

    public function create(array $data);

    public function updateOrCreate($where, $data = null);

    public function createMultiple(array $data);

    public function delete();

    public function deleteById(int $id): ?bool;

    public function deleteMultipleById(array $ids);

    public function first(array $columns = ['*']);

    public function get(array $columns = ['*']);

    public function getById($id, array $columns = ['*']);

    public function getByColumn($item, $column, array $columns = ['*']);

    public function paginate($limit = 25, array $columns = ['*'], $pageName = 'page', $page = null);

    public function updateById($id, array $data, array $options = []);

    public function limit($limit);

    public function orderBy(string $column, string $direction);

    public function where($column, $value, $operator = '=');

    public function whereIn($column, $value);

    public function with($relations);
}
