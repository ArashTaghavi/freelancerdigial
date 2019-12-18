<?php

namespace App\Models;

use App\EloquentHelpers\HasImage;
use Illuminate\Database\Eloquent\Model;

class MemberTeam extends Model
{
    use HasImage;
    public $image_path = 'member-profile';
    protected $fillable = ['firstname', 'lastname', 'description','profile_image'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
