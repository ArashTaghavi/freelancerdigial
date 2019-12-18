<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailReviewedTeam extends Model
{
    protected $fillable = ['reviewed_team_id', 'team_id', 'score'];


    public function reviewedCompany()
    {
        return $this->belongsTo(ReviewedTeam::class);
    }


}
