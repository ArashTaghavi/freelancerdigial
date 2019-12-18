<?php

namespace App\Models;

use App\EloquentHelpers\HasImage;
use Illuminate\Database\Eloquent\Model;

class CompanyWorkSample extends Model
{
    use HasImage;

    public $image_path = 'company-samplework';
    protected $fillable = ['title', 'description', 'company_id', 'profile_image', 'link'];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
