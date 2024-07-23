<?php

namespace Brunocfalcao\NovaHelpers\Macros;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Field;

Field::macro('capitalizeFirst', function () {
    return $this->displayUsing(function ($value) {
        return Str::ucfirst($value);
    });
});

Field::macro('readonlyIfViaResource', function (string|array $resources = []) {

    return $this->readonly(function ($request) use ($resources) {
        return via_resource($resources);
    });
});

Field::macro('helpError', function ($message) {
    return $this->help("<span class='text-base text-red-500'>{$message}</span>");
});

Field::macro('helpWarning', function ($message) {
    return $this->help("<span class='text-base text-yellow-600'>{$message}</span>");
});

Field::macro('helpInfo', function ($message) {
    return $this->help("<span class='text-base text-primary-500'>{$message}</span>");
});

Field::macro('resolveOnIndex', function ($value) {});
