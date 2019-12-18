<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailReviewedCompany extends Model
{
    protected $fillable = ['reviewed_company_id', 'company_id', 'score'];


    public function reviewedCompany()
    {
        return $this->belongsTo(ReviewedCompany::class);
    }


}
