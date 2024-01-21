<?php

use Brunocfalcao\LaravelHelpers\Utils\DomainPatternIdentifier;
use Laravel\Nova\Notifications\NovaNotification;

if (! function_exists('nova_notify')) {

    /**
     * @param  [type] $notifiable The model instance to notify
     * @param  array  $params  ['message', 'action', 'icon', 'type']
     * @return void
     */
    function nova_notify($notifiable, array $params)
    {
        $notification = NovaNotification::make();

        foreach (['message', 'action', 'icon', 'type'] as $key) {
            if (array_key_exists($key, $params)) {
                $notification->$key($params[$key]);
            }
        }

        $notifiable->notify($notification);
    }
}

/**
 * Returns a boolean in case the resource that is being targeted is being
 * called related to other parent resource. As example, if you select
 * "create chapter" inside the courses detail view, then you are
 * "via_resource('courses')".
 */
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
