<?php

namespace Brunocfalcao\LaravelNovaHelpers\Fields;

use Laravel\Nova\Fields\Text;

class BelongsToThrough
{
    public static function make($name, $relationshipCallback, $resourceClass)
    {
        return Text::make($name)
            ->resolveUsing(function ($resource) use ($relationshipCallback, $resourceClass) {
                try {
                    $relatedResource = call_user_func($relationshipCallback, $resource);
                    if (! $relatedResource) {
                        return null;
                    }

                    $resourceInstance = new $resourceClass($relatedResource);
                    $title = $resourceInstance->title();
                    $resourceId = $relatedResource->getKey();
                    $resourceName = $resourceInstance->uriKey();

                    return "<a class=\"link-default\" href='/resources/{$resourceName}/{$resourceId}'>{$title}</a>";
                } catch (\Exception $e) {
                    return null;
                }
            })
            ->exceptOnForms()
            ->asHtml();
    }
}
