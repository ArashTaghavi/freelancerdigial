<?php

namespace App;

use App\EloquentHelpers\HasImage;
use App\models\Cv;
use App\Models\FreeLancerWorkSample;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use HasImage;
    public $image_path = 'user-profile';

    const USER = 2;
    const INSPECTOR = 3;
    const CLIENT = 4;
    const TEAM = 5;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username','email', 'type','password', 'profile_image'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cv()
    {
        return $this->hasOne(Cv::class);
    }

    //FreeLancer WorkSamples
    public function fworkSamples()
    {
        return $this->hasMany(FreeLancerWorkSample::class);
    }

}
