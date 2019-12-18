<?php

namespace App\Http\Controllers\api\user;

use App\models\Cv;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->handleValidate($request)) {
            $cv = new Cv();
            $file = $request->file('user_idss');
            if ($file) {
                $destinationPath = 'uploads';
                $file->move($destinationPath, $file->getClientOriginalName());
            }
            $cv->user_id = 1;
            $cv->fill($request->all());
            $cv->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function handleValidate(Request $request, $user_id = null)
    {
        $validator = \Validator::make($request->all(), [
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            abort(402, $validator->errors()->first());
        }

        return $validator->getData();
    }
}
