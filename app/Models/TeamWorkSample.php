<?php

namespace App\Models;

use App\EloquentHelpers\HasImage;
use Illuminate\Database\Eloquent\Model;

class TeamWorkSample extends Model
{
    use HasImage;

    public $image_path = 'team-samplework';
    protected $fillable = ['title', 'description', 'team_id', 'profile_image', 'link'];


    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
