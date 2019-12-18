<?php

namespace App\EloquentHelpers;

trait HasMonth
{
    public function getMonthNameAttribute()
    {
        return j_month_name($this->attributes['month']);
    }
}