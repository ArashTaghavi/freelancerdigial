<?php

namespace App\EloquentHelpers;

use Illuminate\Support\Facades\URL;
use Route;

trait Linkable
{
    public function linkable()
    {
        return $this->morphTo();
    }

    public function getDestinationAttribute()
    {
        if (!empty($this->attributes['target_url'])) {
            return URL::to($this->attributes['target_url']);
        }

        $model = $this->linkable;

        if (!empty($model)) {
            if (get_class($model) == \App\Page::class) {
                if (Route::has($model->route_name)) {
                    return route($model->route_name);
                }
            } else {
                if (Route::has($model->displayRoute)) {
                    return route($model->displayRoute, ['slug' => $model->slug]);
                }
            }
        }

        return null;
    }

    public function getLinkableTitleAttribute()
    {
        return optional($this->linkable)->title;
    }
}