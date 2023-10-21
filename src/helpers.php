<?php

use Brunocfalcao\LaravelHelpers\Utils\DomainPatternIdentifier;

if (! function_exists('via_resource')) {
    function via_resource(string|array $resources = [])
    {
        if (is_string($resources)) {
            $resources = [$resources];
        }

        $url = DomainPatternIdentifier::parseUrl();

        $viaResourceEval =
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

        $associatableEval =
            // HTTP method is GET.
            request()->isMethod('GET') &&

            // 'associatable' on index '2'.
            data_get($url['path_segments'], 2) == 'associatable' &&

            (
                // uriKey on index 1.
                in_array(data_get($url['path_segments'], 1), $resources) ||

                // In case there are no resources, then it's any associatable.
                $resources == []
            );

        return $viaResourceEval || $associatableEval;
    }
}
