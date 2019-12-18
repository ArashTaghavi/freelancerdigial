<?php

namespace App\EloquentHelpers;

trait SluggedLink
{
    public function getDestinationAttribute()
    {
        $route_name = $this->displayRoutePath;
        return "/{$route_name}/{$this->slug}";
    }
}