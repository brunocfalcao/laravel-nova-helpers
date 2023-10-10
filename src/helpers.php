<?php

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

            // ViaResource value is one of the argument array values.
            in_array(request()->input('viaResource'), $resources);
    }
}
