<?php

namespace Contracts;

use BaseRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var $model
     * @var $itemsPerPage
     */
    protected $model;
    protected $itemsPerPage;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->makeModel();

        $this->itemsPerPage = config('global.items_per_page', 15);
    }

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * @return Model
     * @throws BindingResolutionException
     * @throws \Exception
     */
    public function makeModel(): Model
    {
        $model = app()->make($this->model());

        if (! $model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of " . Model::class);
        }

        return $this->model = $model;
    }

    public function getAll(array $columns = ['*'])
    {
        return $this->model->get($columns);
    }

    public function getById($id, array $columns = ['*'])
    {
        $row = $this->model->find($id, $columns);

        return is_null($row) ? null : $row;
    }

    public function getByIds(array $ids)
    {
        return $this->model
            ->whereIn('id', $ids)
            ->orderBy('id', 'ASC')
            ->get();
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function firstOrCreate(array $attributes)
    {
        return $this->model->firstOrCreate($attributes);
    }

    public function firstByOrCreateBy(array $firstBy, array $attributes)
    {
        return $this->model->firstOrCreate($firstBy, $attributes);
    }

    public function updateById($id, array $attributes = [])
    {
        return $this->model->where('id', $id)->update($attributes);
    }

    public function updateByEntity(Model $model, array $attributes = [])
    {
        return $model->update($attributes);
    }

    public function updateByIds(array $ids, array $attributes = [])
    {
        return $this->model->whereIn('id', $ids)->update($attributes);
    }

    public function deleteById($id)
    {
        return $this->model->find($id)->delete();
    }

    public function firstByKeyValue($key, $value)
    {
        return $this->model->where($key, $value)->first();
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function latestBy(string $column = "created_at")
    {
        return $this->model->latest($column)->first();
    }

    public function updateOrCreate(array $where, array $updateOrCreate)
    {
        return $this->model->updateOrCreate($where, $updateOrCreate);
    }

    public function deleteByIds(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function forceDeleteById($id)
    {
        // return $this->model->find($id)->forceDelete();
        return $this->model->where('id', $id)->forceDelete();
    }

    public function query()
    {
        if ($this->model instanceof Builder){
            return  $this->model;
        }

        return $this->model->query();
    }
}
