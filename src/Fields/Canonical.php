<?php

namespace Brunocfalcao\LaravelNovaHelpers\Fields;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class Canonical extends Text
{
    public function __construct($name = 'Canonical', $attribute = 'canonical', callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        // Get the current request
        $request = resolve(NovaRequest::class);

        // Extract the resource name from the request
        $resourceName = $request->route('resource');

        // Get the resource instance from the resource name
        $resource = Nova::resourceInstanceForKey($resourceName);

        // Check if the resource is null before proceeding.
        if ($resource) {
            // Get the associated model.
            $model = $resource->newModel();

            // Retrieve the table name from the model.
            $tableName = $model->getTable();

            // Set the rules.
            $this->creationRules('required', 'unique:'.$tableName.','.$attribute);
            $this->updateRules('required', "unique:{$tableName},{$attribute},{{resourceId}}");
        }
    }
}
