<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

interface BaseRepositoryInterface
{
    /**
     * Get all results in database.
     *
     * @param array $columns
     * @return array
     */
    public function getAll(array $columns = ['*']);

    /**
     * Get specific row by id.
     *
     * @param $id
     * @param array $columns
     * @return array|null
     */
    public function getById($id, array $columns = ['*']);

    /**
     * Get results ORM instance by ids.
     *
     * @param  array  $ids
     * @return array|null
     */
    public function getByIds(array $ids);

    /**
     * Create a new row via ORM.
     *
     * @param  array  $attributes
     * @return array
     */
    public function create(array $attributes);

    /**
     * Find first result or create new record based on attributes.
     *
     * @param  array  $attributes
     * @return array
     */
    public function firstOrCreate(array $attributes);

    /**
     * Find a row based on $firstBy or if does not exist create new row based on attributes.
     *
     * @param  array  $firstBy
     * @param  array  $attributes
     * @return array
     */
    public function firstByOrCreateBy(array $firstBy, array $attributes);

    /**
     * Update the model in the database by an identifier.
     *
     * @param $id
     * @param  array  $attributes
     * @return bool|int
     */
    public function updateById($id, array $attributes = []);

    /**
     * Update the model in the database by model object entity.
     *
     * @param Model $model
     * @param array $attributes
     * @return bool|mixed
     */
    public function updateByEntity(Model $model, array $attributes = []);

    /**
     * Update the model in the database by identifiers.
     *
     * @param  array  $ids
     * @param  array  $attributes
     * @return bool|int
     */
    public function updateByIds(array $ids, array $attributes = []);

    /**
     * Delete the model in the database by an identifier.
     *
     * @param $id
     * @return bool
     */
    public function deleteById($id);

    /**
     * Find first By Key Value.
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public function firstByKeyValue($key, $value);

    /**
     * Find a row based on id or Fail and throw an exception.
     *
     * @param $id
     * @return bool
     */
    public function findOrFail($id);

    /**
     * Get latest results by specific column.
     *
     * @param string $column
     * @return bool
     */
    public function latestBy(string $column);

    /**
     * Create a row if does not exist otherwise create a row based on attributes.
     *
     * @param array $where
     * @param array $updateOrCreate
     * @return array
     */
    public function updateOrCreate(array $where, array $updateOrCreate);

    /**
     * Delete the model in the database by an identifier.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteByIds(array $ids);

    /**
     * Force delete the model in the database by an identifier.
     *
     * @param $id
     * @return bool
     */
    public function forceDeleteById($id);

    /**
     * Use model query function
     *
     * @return Builder
     */
    public function query();
}
