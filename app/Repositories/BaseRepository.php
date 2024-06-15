<?php

namespace App\Repositories;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository.
 */
abstract class BaseRepository implements RepositoryContract
{
    /**
     * The repository model.
     *
     * @var Model
     */
    protected Model $model;

    protected Builder $query;

    /**
     * Alias for the query limit.
     *
     * @var int|null
     */
    protected ?int $take;

    /**
     * Array of related models to eager load.
     *
     * @var array
     */
    protected array $with = [];

    /**
     * Array of one or more where clause parameters.
     *
     * @var array
     */
    protected array $wheres = [];

    /**
     * Array of one or more where in clause parameters.
     *
     * @var array
     */
    protected array $whereIns = [];

    /**
     * Array of one or more ORDER BY column/value pairs.
     *
     * @var array
     */
    protected array $orderBys = [];

    /**
     * Array of scope methods to call on the model.
     *
     * @var array
     */
    protected array $scopes = [];

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * @return Model
     * @throws Exception
     */
    public function makeModel(): Model
    {
        $model = app()->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of " . Model::class);
        }

        return $this->model = $model;
    }

    /**
     * Get all the model records in the database.
     *
     * @param array $columns
     *
     * @return Collection|static[]
     */
    public function all(array $columns = ['*'])
    {
        $this->newQuery()->eagerLoad();

        $models = $this->query->get($columns);

        $this->unsetClauses();

        return $models;
    }

    /**
     * Count the number of specified model records in the database.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->get()->count();
    }

    /**
     * Create a new model record in the database.
     *
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data): Model
    {
        $this->unsetClauses();

        $model = $this->model->create($data);

        return $model->fresh();
    }

    /**
     * Create one or more new model records in the database.
     *
     * @param array $data
     *
     * @return Collection
     */
    public function createMultiple(array $data): Collection
    {
        $models = new Collection();

        foreach ($data as $d) {
            $models->push($this->create($d));
        }

        return $models;
    }

    /**
     * Delete one or more model records from the database.
     *
     * @return mixed
     */
    public function delete(): mixed
    {
        $this->newQuery()->setClauses()->setScopes();

        $result = $this->query->delete();

        $this->unsetClauses();

        return $result;
    }

    /**
     * Delete the specified model record from the database.
     *
     * @param int $id
     *
     * @return bool|null
     */
    public function deleteById(int $id): ?bool
    {
        $this->unsetClauses();

        return $this->getById($id)?->delete();
    }

    /**
     * Delete the specified model record from the database.
     *
     * @param int $id
     *
     * @return bool|null
     */
    public function deleteByUuid(string $id): ?bool
    {
        $this->unsetClauses();

        return $this->getById($id)?->delete();
    }

    /**
     * Delete multiple records.
     *
     * @param array $ids
     *
     * @return int
     */
    public function deleteMultipleById(array $ids): int
    {
        return $this->model->destroy($ids);
    }

    /**
     * Get the first specified model record from the database.
     *
     * @param array $columns
     *
     * @return Model|static
     */
    public function first(array $columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $model = $this->query->firstOrFail($columns);

        $this->unsetClauses();

        return $model;
    }

    /**
     * Get all the specified model records in the database.
     *
     * @param array $columns
     *
     * @return Collection|static[]
     */
    public function get(array $columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->get($columns);

        $this->unsetClauses();

        return $models;
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Get the specified model record from the database.
     *
     * @param       $id
     * @param array $columns
     *
     * @return null|Model
     */
    public function getById($id, array $columns = ['*'])
    {
        $this->unsetClauses();

        $this->newQuery()->eagerLoad();

        return $this->query->find($id, $columns);
    }

    /**
     * @param       $item
     * @param       $column
     * @param array $columns
     *
     * @return Model|null|static
     */
    public function getByColumn($item, $column, array $columns = ['*'])
    {
        $this->unsetClauses();

        $this->newQuery()->eagerLoad();

        return $this->query->where($column, $item)->first($columns);
    }

    /**
     * @param int $limit
     * @param array $columns
     * @param string $pageName
     * @param null $page
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($limit = 25, array $columns = ['*'], $pageName = 'page', $page = null)
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->paginate($limit, $columns, $pageName, $page);

        $this->unsetClauses();

        return $models;
    }

    /**
     * Update the specified model record in the database.
     *
     * @param       $id
     * @param array $data
     * @param array $options
     *
     * @return Model|null
     */
    public function updateById($id, array $data, array $options = []): ?Model
    {
        $this->unsetClauses();

        $model = $this->getById($id);

        if (array_key_exists('time', $data)) {
            $data['time'] = Carbon::parse($data['time'])->format('H:i:s');
        }

        $model?->update($data, $options);

        return $model;
    }

    public function updateOrCreate($where, $data = null): Model
    {
        $this->unsetClauses();
        $model = new $this->model;

        if (is_null($data)) {
            if (!isset($where['id'])) {
                return $model->create($where);
            }

            return $model->updateOrCreate([
                'id' => $where['id'],
            ], $where);
        }

        return $model->updateOrCreate($where, $data);
    }

    /**
     * Set the query limit.
     *
     * @param int $limit
     *
     * @return self
     */
    public function limit($limit): self
    {
        $this->take = $limit;

        return $this;
    }

    /**
     * Set an ORDER BY clause.
     *
     * @param string $column
     * @param string $direction
     * @return self
     */
    public function orderBy(string $column, string $direction = 'asc'): self
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /**
     * Add a simple where clause to the query.
     *
     * @param string $column
     * @param string $value
     * @param string $operator
     *
     * @return $this
     */
    public function where($column, $value, $operator = '=')
    {
        $this->wheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    /**
     * Add a simple where in clause to the query.
     *
     * @param string $column
     * @param mixed $values
     *
     * @return $this
     */
    public function whereIn($column, $values)
    {
        $values = is_array($values) ? $values : [$values];

        $this->whereIns[] = compact('column', 'values');

        return $this;
    }

    /**
     * Set Eloquent relationships to eager load.
     *
     * @param $relations
     *
     * @return $this
     */
    public function with($relations)
    {
        if (is_string($relations)) {
            $relations = func_get_args();
        }

        $this->with = $relations;

        return $this;
    }

    /**
     * Create a new instance of the model's query builder.
     *
     * @return $this
     */
    protected function newQuery()
    {
        $this->query = $this->model->newQuery();

        return $this;
    }

    /**
     * Add relationships to the query builder to eager load.
     *
     * @return $this
     */
    protected function eagerLoad()
    {
        foreach ($this->with as $relation) {
            $this->query->with($relation);
        }

        return $this;
    }

    /**
     * Set clauses on the query builder.
     *
     * @return $this
     */
    protected function setClauses()
    {
        foreach ($this->wheres as $where) {
            $this->query->where($where['column'], $where['operator'], $where['value']);
        }

        foreach ($this->whereIns as $whereIn) {
            $this->query->whereIn($whereIn['column'], $whereIn['values']);
        }

        foreach ($this->orderBys as $orders) {
            $this->query->orderBy($orders['column'], $orders['direction']);
        }

        if (isset($this->take) and !is_null($this->take)) {
            $this->query->take($this->take);
        }

        return $this;
    }

    /**
     * Set query scopes.
     *
     * @return $this
     */
    protected function setScopes()
    {
        foreach ($this->scopes as $method => $args) {
            $this->query->$method(implode(', ', $args));
        }

        return $this;
    }

    /**
     * Reset the query clause parameter arrays.
     *
     * @return $this
     */
    protected function unsetClauses()
    {
        $this->wheres = [];
        $this->whereIns = [];
        $this->scopes = [];
        $this->take = null;

        return $this;
    }
}