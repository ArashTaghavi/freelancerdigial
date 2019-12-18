<?php

namespace App\EloquentHelpers;

trait HasPublishedAt
{
    public function getPublishedAtAttribute()
    {
        if (empty($this->attributes['published_at']))
            return '';
        $date = verta($this->attributes['published_at']);
        return $date->format('Y/m/d H:i');
    }

    public function getPublishedAtDateAttribute()
    {
        if (empty($this->attributes['published_at']))
            return null;
        $date = verta($this->attributes['published_at']);
        return $date->format('Y/m/d');
    }

    public function getPublishedAtTimeAttribute()
    {
        if (empty($this->attributes['published_at']))
            return null;
        $date = verta($this->attributes['published_at']);
        return $date->format('H:i');
    }
}