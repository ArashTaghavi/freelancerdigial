<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    use Sluggable;
    protected $fillable =['title','description','category_id','start_date','end_date','min_price','max_price','profile_image','skill'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
