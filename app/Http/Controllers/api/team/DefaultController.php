<?php

namespace App\Http\Controllers\api\team;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DefaultController extends Controller
{
    public function index()
    {
        $user_info = Auth::user();

        return view('panel.team-vue', compact('user_info'));
    }
}
