<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttachmentCompany extends Model
{
    public $upload_dir = '/uploads/attachment-company/';

    const REGISTERED_AD = 1;
    const VALUE_ADDED = 2;
    const HONORS = 3;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
