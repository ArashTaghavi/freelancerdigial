<?php

namespace App\EloquentHelpers;

trait HasFile
{
    public function unlinkOriginalFile()
    {
        $file = public_path($this->getOriginal('file'));
        if (is_file($file))
            unlink($file);
    }

    public function getHasFileAttribute()
    {
        return $this->attributes['file'] != null;
    }
}