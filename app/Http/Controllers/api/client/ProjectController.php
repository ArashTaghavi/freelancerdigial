<?php

namespace App\Http\Controllers\api\client;

use App\Models\Company;
use App\Models\Team;
use App\Models\Project;
use App\ReservedProject;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Project::where('user_id', Auth::id())->get();
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
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $this->handleValidate($request);
        $project = new Project();
        $project->user_id = Auth::id();
        $project->fill($request->except('profile_image'));

        if (Session::get('upload_introduction'))
            $project->profile_image = json_encode(Session::get('upload_introduction'));

        //$project->fillImage($request);
        $project->skill = !empty($request->skill) ? json_encode($request->skill) : NULL;

        $project->save();
        Session::forget('upload_introduction');

        return ['message' => __('messages.save_success')];
    }

    public function getById($id)
    {
        $project = Project::where('id', $id)->first();

        return $project;
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

    public function update(Request $request, Project $project)
    {
        $this->handleValidate($request);
        $project->fill($request->except('profile_image'));
        $project->skill = !empty($request->skill) ? json_encode($request->skill) : NULL;
        if (Session::get('upload_introduction'))
            $project->profile_image = json_encode(Session::get('upload_introduction'));
        $project->save();
        Session::forget('upload_introduction');

        return ['message' => __('messages.update_success')];
    }

    /**
     * @param Project $project
     * @return array
     * @throws \Exception
     */
    public function destroy($id)
    {
        $project = Project::where('id', $id)->where('user_id', Auth::id())->first();
        if ($project->profile_image != null && file_exists(public_path(json_decode($project->profile_image)[0]))) {

            unlink(public_path(json_decode($project->profile_image)[0]));
        }
        $project->delete();
        return ['message' => __('messages.delete_success')];
    }

    public function handleValidate(Request $request, $id = null)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'min_price' => 'required',
            'max_price' => 'required',

        ]);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }
        return $validator->getData();
    }

    public function upload_introduction()
    {
        $file = request()->file('file');

        $file_name = time() . '-' . $file->getClientOriginalName();
        $dir = "/uploads/project-introduction";
        $file->move(public_path($dir), $file_name);
        session()->push('upload_introduction', "{$dir}/$file_name");

    }

    public function detail($project_id)
    {
        $project = Project::whereHas('reservedProject', function ($q) use ($project_id) {
            $q->where('company_id', 0)
                ->where('team_id', 0)
                ->where('user_id', Auth::id())
                ->where('project_id', $project_id);
        })->get();
        return $project;
    }

    public function reserved($id)
    {
        $reserved = ReservedProject::with('project')
            ->where('project_id', $id)
            ->first();
        return $reserved;
    }

    public function get_functor($id)
    {
        //id ==> project_id
        $reservedProject = ReservedProject::where('project_id', $id)->first();
        if ($reservedProject->company_id != 0) {
            $company = Company::find($reservedProject->company_id);
            return ['type' => 'شرکت', 'title' => $company->title, 'image' => $company->profile_image];
        } elseif ($reservedProject->team_id != 0) {
            $team = Team::find($reservedProject->team_id);
            return ['type' => 'تیم', 'title' => $team->title, 'image' => $team->profile_image];
        } else {
            $user = User::find($reservedProject->user_id);
            return ['type' => 'فریلنسر', 'title' => $user->first_name . ' ' . $user->last_name, 'image' => $user->profile_image];

        }
    }

    public function get_developer($id)
    {
        //id ==> project_id
        $reservedProject = ReservedProject::where('project_id', $id)->first();
        if ($reservedProject->company_id != 0) {
            $company = Company::find($reservedProject->company_id);

            return ['type' => 'شرکت', 'title' => $company->title, 'image' => $company->profile_image];
        } elseif ($reservedProject->team_id != 0) {
            $team = Team::find($reservedProject->team_id);
            return ['type' => 'تیم', 'title' => $team->title, 'image' => $team->profile_image];
        } else {
            $user = User::find($reservedProject->user_id);
            return ['type' => 'فریلنسر', 'title' => $user->first_name . ' ' . $user->last_name, 'image' => $user->profile_image];

        }
    }


}
