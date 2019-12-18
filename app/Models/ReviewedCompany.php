<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewedCompany extends Model
{
    protected $fillable = ['company_id', 'description', 'star'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function details()
    {
        return $this->hasMany(DetailReviewedCompany::class);
    }
}
