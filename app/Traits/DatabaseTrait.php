<?php

namespace App\Traits;

trait DatabaseTrait
{

    /**
     * @param array $data
     * @return null|object
     */
    public static function saveData(array $data): ?object
    {
        $data['addedFrom'] = auth()->id();
        $data['companyId'] = empty($data['companyId']) ? 1 : $data['companyId'];
        $data['created_at'] = now();
        return self::query()->firstOrCreate($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public static function updateData($id, array $data): mixed
    {
        $data['updatedFrom'] = auth()->id();
        $data['companyId'] = empty($data['companyId']) ? 1 : $data['companyId'];
        return self::query()->find($id)->update($data);
    }

    /**
     * @param array $where
     * @param array $columns
     * @param bool $toArray
     * @return mixed
     */
    public static function getData(array $where = [], array $columns = ['*'],bool $toArray = false): mixed
    {
        if ($toArray === true) {
            return self::query()->where($where)->get($columns)->toArray();
        }
        return self::query()->where($where)->get($columns);
    }

    /**
     * @param $id
     * @param bool $isToArray
     * @param string[] $column
     * @return mixed
     */
    public static function getDataFromId($id, $isToArray = false, $column = ['*']): mixed
    {
        if ($isToArray) {
            return self::query()->find($id, $column)->toArray();
        }

        return self::query()->find($id, $column);
    }

    /**
     * @param array $where
     * @return int
     */
    public static function getCount(array $where = []): int
    {
        return self::query()->where($where)->count();
    }

    /**
     * @param $param
     * @param $value
     * @return int
     */
    public static function getCountWithLike($param, $value): int
    {
        return self::query()->where($param, 'like', $value . '%')->count();
    }

    /**
     * @param array $where
     * @param array $relation
     * @param bool $isArray
     * @return object|array|null
     */
    public static function getRelationData(array $where = [], array $relation = [], bool $isArray = false): object|array|null
    {
        if ($isArray === true) {
            return self::with($relation)->where($where)->get()->toArray();
        }

        return self::with($relation)->where($where)->get();
    }

    /**
     * @param string $id
     * @param array $relation
     * @param bool $isToArray
     * @return mixed
     */
    public static function getFindRelationData(string $id, array $relation = [], bool $isToArray = false): mixed
    {
        if ($isToArray === true) {
            return self::with($relation)->find($id)->toArray();
        }

        return self::with($relation)->find($id);
    }

    /**
     * @param array $where
     * @return bool
     */
    public static function checkExists(array $where = []): bool
    {
        return self::query()->where($where)->exists();
    }

    /**
     * @param string $id
     * @param array $where
     * @return bool
     */
    public static function checkExistsWithId(string $id, array $where = []): bool
    {
        return self::query()->where('_id', '!=', $id)->where($where)->exists();
    }

    /**
     * @param string $field
     * @param array $ids
     * @param bool $isArray
     * @return object|array
     */
    public static function whereInData(string $field, array $ids, bool $isArray = false): object|array
    {
        if ($isArray === true) {
            return self::query()->whereIn($field, $ids)->get()->toArray();
        }

        return self::query()->whereIn($field, $ids)->get();
    }

    /**
     * @param string $field
     * @param array $ids
     * @param array $with
     * @param bool $isArray
     * @return object|array|null
     */
    public static function withWhereInData(string $field, array $ids, array $with, bool $isArray = false): object|array|null
    {
        if ($isArray === true) {
            return self::query()->with($with)->whereIn($field, $ids)->get()->toArray();
        }

        return self::query()->with($with)->whereIn($field, $ids)->get();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public static function deleteData(array $where): mixed
    {
        return self::query()->where($where)->delete();
    }

    /**
     * @param $id
     * @return int
     */
    public static function destroyData($id): int
    {
        return self::destroy($id);
    }

    /**
     * @param array $where
     * @param $fields
     * @param bool $toArray
     * @return object|array|null
     */
    public static function pluckData(array $where, $fields, bool $toArray = false): object|array|null
    {
        if ($toArray === true) {
            return self::query()->where($where)->pluck($fields)->toArray();
        }

        return self::query()->where($where)->pluck($fields);
    }

    /**
     * @param array $where
     * @param string[] $columns
     * @param bool $isArray
     * @return mixed
     */
    public static function getFirstData(array $where = [], $columns = ['*'], bool $isArray = false): mixed
    {
        if ($isArray === true) {
            return self::query()->where($where)->first($columns)->toArray();
        }

        return self::query()->where($where)->first($columns);
    }

    /**
     * @param array $where
     * @param array $with
     * @param bool $isArray
     * @return mixed
     */
    public static function getFirstDataWithRelation(array $where = [], array $with = [], bool $isArray = false): mixed
    {
        if ($isArray === true) {
            return self::query()->with($with)->where($where)->first()->toArray();
        }

        return self::query()->with($with)->where($where)->first();
    }
}
