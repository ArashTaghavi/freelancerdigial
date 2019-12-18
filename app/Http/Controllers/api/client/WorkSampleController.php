<?php

namespace App\Http\Controllers\api\client;

use App\Http\Controllers\Controller;
use App\Models\FreeLancerWorkSample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WorkSampleController extends Controller
{
    public function list()
    {
        $work_samples = FreeLancerWorkSample::where('user_id', Auth::id())->get();
        return $work_samples;
    }

    public function store(Request $request)
    {
        $this->handleValidate($request);
        $work_sample = new FreelancerWorkSample();
        $work_sample->user_id = Auth::id();
        $work_sample->fill($request->except('profile_image'));
        if (Session::get('upload_introduction'))
            $work_sample->profile_image = json_encode(Session::get('upload_introduction'));

        $work_sample->save();
        Session::forget('upload_introduction');

        return ['message' => __('messages.save_success')];
    }

    public function update(Request $request, $id)
    {
        $this->handleValidate($request);
        $freelancerWorkSample = FreeLancerWorkSample::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        $freelancerWorkSample->fill($request->except('profile_image'));
        if (Session::get('upload_introduction'))
            $freelancerWorkSample->profile_image = json_encode(Session::get('upload_introduction'));
        $freelancerWorkSample->save();
        Session::forget('upload_introduction');
        return ['message' => __('messages.update_success')];
    }

    public function handleValidate(Request $request, $id = null)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }
        return $validator->getData();
    }

    public function get_by_id($id)
    {
        $freelancerWorkSample = FreeLancerWorkSample::where('id', $id)
            ->where('user_id', Auth::id())->first();

        return $freelancerWorkSample;
    }

    public function destroy($id)
    {
        $freelancerWorkSample = FreeLancerWorkSample::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        if ($freelancerWorkSample->profile_image != null) {
            foreach (json_decode($freelancerWorkSample->profile_image) as $file) {
                unlink(public_path($file));
            }
        }
        $freelancerWorkSample->delete();
        return ['message' => __('messages.delete_success')];

    }


    public function handleChangeImage($request, $model)
    {
        if (empty($request->profile_image)) {
            if (!empty($model->profile_image)) {
                $model->unlinkOriginalImage();
            }
            $model->profile_image = NULL;
        } else {
            if ($request->profile_image != $model->profile_image) {
                $model->unlinkOriginalImage();
                $model->fillImage($request);
            }
        }
    }

    public function upload_introduction()
    {
        $file = request()->file('file');

        $file_name = time() . '-' . $file->getClientOriginalName();
        $dir = "/uploads/work-sample-introduction";
        $file->move(public_path($dir), $file_name);
        session()->push('upload_introduction', "{$dir}/$file_name");

    }

}

