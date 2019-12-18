<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = ['active', 'title'];


    public function reviewed()
    {
        return $this->belongsTo(ReviewedCompany::class);
    }
}
