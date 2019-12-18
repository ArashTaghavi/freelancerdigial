<?php

namespace App;

use App\EloquentHelpers\HasImage;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasImage;

    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'min_price',
        'max_price', 'profile_image','category_id'];

    public $image_path = 'project-profile';

    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function reservedProject(){
        return $this->hasOne(ReservedProject::class);
    }
}
