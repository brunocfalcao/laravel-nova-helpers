<?php

use App\Nova\Resource;
use Brunocfalcao\LaravelHelpers\Utils\DomainPatternIdentifier;
use Laravel\Nova\Http\Requests\NovaRequest;

if (!function_exists('on_index')) {
    function on_index(Resource $resource = null)
    {
        $url = DomainPatternIdentifier::parseUrl();

        // Stronger comparison if the Resource argument is passed.
        $exists = $resource ?
                    end($url['path_segments']) == $resource->uriKey() :
                    true;

        return
            // E.g.: nova-api/authorizations (nothing else)
            count($url['path_segments']) == 2 &&
            // The last index is the resource uri key (e.g: authorizations)
            $exists &&
            // Request method is always GET.
            request()->method() == 'GET';
    }
}

if (! function_exists('via_resource')) {
    function via_resource(string|array $resources = [])
    {
        if (is_string($resources)) {
            $resources = [$resources];
        }

        return
            // HTTP method is GET.
            request()->isMethod('GET') &&

            // There is a query key 'viaResource'.
            request()->has('viaResource') &&

            // And that viaResource key is not blank.
            ! blank(request()->input('viaResource')) &&

            (
                // ViaResource value is one of the argument array values.
                in_array(request()->input('viaResource'), $resources) ||

                // In case there are no resources, then it's any viaResource.
                $resources == []
            );
    }
}
