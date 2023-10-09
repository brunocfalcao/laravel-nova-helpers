<?php

if (! function_exists('via_resource')) {
    function via_resource(string $viaResource)
    {
        $segments = request()->segments();

        return in_array($viaResource, $segments);
    }
}
