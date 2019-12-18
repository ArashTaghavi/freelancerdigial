<?php

namespace App\EloquentHelpers;

trait HasTimestamps
{
    public function getCreatedAtAttribute()
    {
        if (empty($this->attributes['created_at']))
            return null;
        $date = verta($this->attributes['created_at']);
        return $date->format('Y/m/d H:i');
    }

    public function getUpdatedAtAttribute()
    {
        if (empty($this->attributes['updated_at']))
            return null;
        $date = verta($this->attributes['updated_at']);
        return $date->format('Y/m/d H:i');
    }
}