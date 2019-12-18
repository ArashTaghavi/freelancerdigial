<?php

namespace App\Model;

use App\EloquentHelpers\HasImage;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class CompanyMember extends Model
{
    use HasImage;
    public $image_path = 'member-profile';
    protected $fillable = ['firstname', 'lastname', 'description','profile_image'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
