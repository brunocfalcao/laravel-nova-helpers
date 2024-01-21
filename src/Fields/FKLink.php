<?php

namespace Brunocfalcao\LaravelNovaHelpers\Fields;

use Laravel\Nova\Fields\Text;

class FKLink extends Text
{
    public function __construct($name, $attribute, $resourceClass)
    {
        parent::__construct($name, $attribute);

        $this->displayUsing(function ($value, $resource) use ($attribute, $resourceClass) {
            $idValue = data_get($resource, $attribute);

            // Handle pivot columns
            if (! $idValue && $resource->pivot) {
                $idValue = $resource->pivot->{$attribute};
            }

            if ($idValue) {
                $model = $resourceClass::newModel()->find($idValue);
                $novaResource = new $resourceClass($model);

                // Check for title() method or $title attribute
                if (method_exists($novaResource, 'title')) {
                    $displayValue = $novaResource->title();
                } else {
                    $titleColumn = $resourceClass::$title;
                    $displayValue = $model->$titleColumn;
                }
            } else {
                $displayValue = '-';
            }

            $resourceUriKey = $resourceClass::uriKey();

            $prefix = config('nova.path');
            if (! str_ends_with($prefix, '/')) {
                $prefix.'/';
            }

            $url = config('nova.path')."/resources/{$resourceUriKey}/{$idValue}";

            return "<a class=\"link-default\" href='{$url}'>{$displayValue}</a>";
        });

        $this->exceptOnForms();
        $this->asHtml();
    }
}
