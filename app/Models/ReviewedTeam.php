<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewedTeam extends Model
{
    protected $fillable = ['team_id', 'description', 'star'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function details()
    {
        return $this->hasMany(DetailReviewedTeam::class);
    }
}
