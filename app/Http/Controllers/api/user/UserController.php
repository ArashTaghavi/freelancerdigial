<?php

namespace App\Http\Controllers\api\user;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        return Auth::user();
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($this->updateValidate($request)) {
            $user->fill($request->except('password', 'username'));
            if (!empty($request->profile_image)) {
                if (!empty($user->profile_image)) {
                    $user->unlinkOriginalImage();
                }
                $user->fillImage($request);
            }
            $user->save();
        }
        return ['message' => __('messages.save_success')];

    }

    public function updateValidate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email'
        ]);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }

        return $validator->getData();
    }

}
