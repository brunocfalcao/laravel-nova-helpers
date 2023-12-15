<?php

namespace Brunocfalcao\LaravelNovaHelpers\Traits;

use Illuminate\Support\Str;

/**
 * The Nova missing methods to help you make the Nova experience a bit
 * better :)
 *
 * You just add this trait to any of your classes and there you go.
 */
trait NovaHelpers
{
    /**
     * Returns you a full context tree from where you are in terms of your
     * resource data, relationship, editing context, resources connected, etc.
     *
     * @return array
     */
    public function novaGetContext()
    {
        $segments = request()->segments() ?? [];
        $queryParams = request()->query() ?? [];
        $method = request()->method();

        $result = null;

        if (empty(request()->query()) && request()->method() === 'GET') {
            return 'index';
        }

        if (request()->query('editMode') === 'create' && request()->method() === 'GET') {
            return 'creating';
        }

        if (request()->query('editMode') === 'create' && request()->method() === 'POST') {
            return 'created';
        }

        if (request()->query('editMode') === 'update' && request()->method() === 'GET') {
            return 'updating';
        }

        if (request()->query('editMode') === 'update' && request()->method() === 'PUT') {
            return 'updated';
        }

        if (request()->method() === 'PUT' && $this->novaSegmentOn('restore', 2)) {
            return 'restored';
        }

        if (request()->method() === 'DELETE' && ! $this->novaSegmentOn('force', 2)) {
            return 'deleted';
        }

        if (request()->method() === 'DELETE' && $this->novaSegmentOn('force', 2)) {
            return 'force-deleted';
        }

        // Last one.
        return 'detail';
    }

    /**
     * This is when you are executing an operation that came from a parent
     * Resource. For instance, when you click on a "CREATE <xxx>" Resource
     * child relationship inside the detail view of another Resource.
     *
     * @return null|Model
     */
    public function novaGetParentModel(string $resourceNamespacePrefix = 'App\\Nova')
    {
        $viaResource = request()->query('viaResource');
        $viaResourceId = request()->query('viaResourceId');

        if (! empty($viaResource) && ! empty($viaResourceId)) {
            $resourceClass = "{$resourceNamespacePrefix}\\".Str::studly(Str::singular($viaResource));

            if (class_exists($resourceClass)) {
                return $resourceClass::newModel()->find($viaResourceId);
            }
        }

        return null;
    }

    /**
     * Verifies if a segment value is on the righr url path segments indexes.
     *
     * @return bool
     */
    private function novaSegmentOn(string $segment, ?int $position = null)
    {
        if (! $position) {
            $segments = request()->segments();

            return in_array($segment, $segments);
        }

        $segments = request()->segments();

        return isset($segments[$position]) && $segments[$position] === $segment;
    }
}
