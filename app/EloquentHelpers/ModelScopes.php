<?php

namespace App\EloquentHelpers;

trait ModelScopes
{
    /**
     * Scope a query to only include popular Users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        $now = now()->format('Y-m-d H:i:s');
        return $query->where('is_published', '=', 1)
            ->where('published_at', '<', $now)
            ->where(function ($query) use ($now) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                return $query->whereNull('expired_at')
                    ->orWhere('expired_at', '>', $now);
            });
    }

    /**
     * Scope a query to only include popular Users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePendingApproval($query)
    {
        return $query->where('is_published', '=', 0);
    }

    /**
     * Scope a query to only include popular Users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSticky($query)
    {
        return $query->where('is_sticky', '=', 1);
    }

    /**
     * Scope a query to only include popular Users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrivate($query)
    {
        return $query->where('is_private', '=', 1);
    }

    /**
     * Scope a query to only include popular Users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotPrivate($query)
    {
        return $query->where('is_private', '=', 0);
    }

    /**
     * Scope a query to only include popular Users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasFile($query)
    {
        return $query->whereNotNull('file');
    }

    /**
     * Scope a query to only include popular Users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStickyFirst($query){
        return $query->orderBy('is_sticky', 'desc');
    }

    /**
     * Scope a query to only include popular Users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLast($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Scope a query to only include popular Users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastCreated($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to only include popular Users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortByOrder($query)
    {
        return $query->orderBy(\DB::raw('ABS(sort_order)'), 'asc');
    }
}