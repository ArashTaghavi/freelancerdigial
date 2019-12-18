<?php

namespace App\Http\Controllers\api\client;

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
        $this->updateValidate($request);
            $user->fill($request->except('password', 'username', 'profile_image'));
            $this->handleChangeImage($request, $user);
            $user->save();

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

    public function handleChangeImage($request, $model)
    {
        if (empty($request->profile_image)) {
            $model->unlinkOriginalImage();
            $model->profile_image = NULL;
        } else {
            if ($request->profile_image != $model->profile_image) {
                $model->unlinkOriginalImage();
                $model->fillImage($request);
            }
        }
    }


}
