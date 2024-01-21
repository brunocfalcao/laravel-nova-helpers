<?php

namespace Brunocfalcao\LaravelNovaHelpers\Traits;

/**
 * Sorts the resource in the index view by it's default PK (ascending).
 */
trait DefaultAscPKSorting
{
    public static function defaultOrderings($query)
    {
        $model = $query->getModel();
        $table = $model->getTable();
        $keyName = $model->getKeyName();

        return $query->orderBy("{$table}.{$keyName}");
    }
}
