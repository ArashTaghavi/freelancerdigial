<?php

namespace App\EloquentHelpers;

use App\Language;

trait Multilingual
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Scope a query to only include Users of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $locale
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfLocale($query, $locale = null)
    {
        if (empty($locale)) {
            $locale = \App::getLocale();
        }

        $language_id = Language::whereCode($locale)->first()->id;
        return $query->where('language_id', $language_id);
    }
}