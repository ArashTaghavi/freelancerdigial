<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $fillable = ['description', 'attachment'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
