<?php

namespace App\Models;

use App\EloquentHelpers\HasImage;
use App\Model\CompanyMember;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasImage;

    protected $fillable = ['title', 'description', 'profile_image', 'category_id', 'tags', 'member_count', 'address', 'activity_duration'];

    public $image_path = 'company-profile';

    public $casts = ['tags' => 'array'];

    public function attachments()
    {
        return $this->hasMany(AttachmentCompany::class);
    }

    public function Reviewed()
    {
        return $this->hasOne(ReviewedCompany::class);
    }

    public function workSamples()
    {
        return $this->hasMany(CompanyWorkSample::class);
    }

    public function members()
    {
        return $this->hasMany(CompanyMember::class);
    }

}
