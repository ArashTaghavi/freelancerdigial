<?php

namespace App\EloquentHelpers;

trait HasDuration
{
    public function getDurationHourAttribute()
    {
        if($this->duration == '00:00')
            return 0;
        $duration_array = explode(':', $this->duration);
        return $duration_array[0];
    }

    public function getDurationMinuteAttribute()
    {
        if($this->duration == '00:00')
            return 0;
        $duration_array = explode(':', $this->duration);
        return $duration_array[1];
    }

}