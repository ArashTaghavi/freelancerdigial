<?php

namespace App\Models;

use App\EloquentHelpers\HasImage;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasImage;

    protected $fillable = ['title', 'description', 'profile_image', 'category_id', 'tags', 'member_count', 'address', 'activity_duration'];

    public $image_path = 'team-profile';

    public $casts = ['tags' => 'array'];

    //Team Work Sample
    public function tworkSamples()
    {
        return $this->hasMany(TeamWorkSample::class);
    }

    //Team Members
    public function tmembers()
    {
        return $this->hasMany(MemberTeam::class);
    }

    // Team Reviewed
    public function treviewed()
    {
        return $this->hasOne(ReviewedTeam::class);
    }
}
