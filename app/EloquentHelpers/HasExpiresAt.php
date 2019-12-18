<?php

namespace App\EloquentHelpers;

trait HasExpiresAt
{
    public function getExpiresAtAttribute()
    {
        if (empty($this->attributes['expires_at']))
            return '';
        $date = verta($this->attributes['expires_at']);
        return $date->format('Y/m/d');
    }

    public function getExpiresAtDateAttribute()
    {
        if (empty($this->attributes['expires_at']))
            return null;
        $date = verta($this->attributes['expires_at']);
        return $date->format('Y/m/d');
    }

    public function getExpiresAtTimeAttribute()
    {
        if (empty($this->attributes['expires_at']))
            return null;
        $date = verta($this->attributes['expires_at']);
        return $date->format('H:i');
    }

    public function getIsExpiresAttribute()
    {
        if (empty($this->attributes['expires_at'])) {
            return false;
        } else {
            $now = now()->format('Y-m-d H:i:s');
            return $this->attributes['expires_at'] < $now;
        }
    }
}
