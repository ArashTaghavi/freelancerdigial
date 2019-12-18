<?php

namespace App\Models;

use App\EloquentHelpers\HasImage;
use App\User;
use Illuminate\Database\Eloquent\Model;

class FreelancerWorkSample extends Model
{
    use HasImage;

    public $image_path = 'user-samplework';
    protected $fillable = ['title', 'description', 'user_id', 'profile_image', 'link'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
