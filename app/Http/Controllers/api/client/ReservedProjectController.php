<?php

namespace App\Http\Controllers\api\client;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Team;
use App\Project;
use App\User;
use Illuminate\Support\Facades\Auth;

class ReservedProjectController extends Controller
{

    public function index()
    {
        $projects = Project::whereHas('reservedProject', function ($q) {
            $q->where('company_id', 0)
                ->where('team_id', 0)
                ->where('user_id', Auth::id());
        })->get();
        return $projects;
    }

    public function get_by_id($project_id)
    {
        $project = Project::whereHas('reservedProject', function ($q) use ($project_id) {
            $q->where('company_id', 0)
                ->where('team_id', 0)
                ->where('user_id', Auth::id())
                ->where('project_id', $project_id);
        })->get();
        return $project;
    }

    public function get_owner(Project $project)
    {
        if ($project->company_id != 0) {
            $company = Company::find($project->company_id);
            return ['type' => 'شرکت', 'title' => $company->title, 'image' => $company->profile_image];
        } elseif ($project->team_id != 0) {
            $team = Team::find($project->team_id);
            return ['type' => 'تیم', 'title' => $team->title, 'image' => $team->profile_image];
        } else {
            $user = User::find($project->user_id);
            return ['type' => 'فریلنسر', 'title' => $user->first_name . ' ' . $user->last_name, 'image' => $user->profile_image];

        }
    }

}
