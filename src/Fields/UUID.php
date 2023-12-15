<?php

namespace Brunocfalcao\LaravelNovaHelpers\Fields;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class UUID extends Text
{
    public function __construct($name = 'UUID', $attribute = 'uuid', ?callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $request = resolve(NovaRequest::class);

        $resourceName = $request->route('resource');
        $resourceId = $request->route('resourceId');

        $resource = Nova::resourceInstanceForKey($resourceName);

        if (! $resource) {
            return;
        }

        $model = $resource->newModel();
        $tableName = $model->getTable();

        $this->hideFromIndex();

        $this->readonly();
        $this->hideWhenCreating();

        if ($resourceId) {
            // If updating, ignore the current model ID
            $this->rules('required', 'uuid', 'unique:'.$tableName.','.$attribute.','.$resourceId);
        } else {
            // If creating, apply the regular unique validation
            $this->rules('uuid', 'unique:'.$tableName.','.$attribute);
        }
    }
}
