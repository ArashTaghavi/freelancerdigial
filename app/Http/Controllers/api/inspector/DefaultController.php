<?php

namespace App\Http\Controllers\api\inspector;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DefaultController extends Controller
{
    public function index()
    {
        return view('panel.inspector-vue');
    }
}
