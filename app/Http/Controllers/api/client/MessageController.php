<?php

namespace App\Http\Controllers\api\client;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Project;
use App\ReservedProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{
    public function get_by_project_id($project_id)
    {
        $messages = Message::where(function ($query) {
            return $query->where('sender_id', Auth::id())
                ->orWhere('receiver_id', Auth::id());
        })
            ->where('project_id', $project_id)->get();

        return $messages;
    }

    public function store(Request $request, $id, $received_project = true)
    {
        if ($request->fo == 0)
            $received_project = false;
        if($request->fo==1)
            $received_project=true;
        $message = new Message();
        $message->sender_id = Auth::id();
        if ($received_project) {
            $message->receiver_id = Project::where('id', $id)->first()->user_id;
            $message->team_id = $this->check_receiver($id)['team_id'];
            $message->company_id = $this->check_receiver($id)['company_id'];
        } else {
            $message->receiver_id = ReservedProject::where('project_id', $id)->first()->user_id;

            $message->team_id = $this->check_receiver($id, false)['team_id'];
            $message->company_id = $this->check_receiver($id, false)['company_id'];
        }
        $message->body = $request->body;
        $message->project_id = $id;
        if (Session::get('upload_attachment'))
            $message->attachment = Session::get('upload_attachment')[0];
        $message->save();
        Session::forget('upload_attachment');
    }

    public function check_receiver($project_id, $received_project = true)
    {
        if ($received_project) {

            $project = Project::where('id', $project_id)->first();
            $receiver_id = ['company_id' => 0, 'team_id' => 0];

            if ($project->company_id != 0) {
                $receiver_id['company_id'] = $project->company_id;
            }
            if ($project->team != 0) {
                $receiver_id['team_id'] = $project->team_id;
            }
            return $receiver_id;
        } else {
            $project = ReservedProject::where('project_id', $project_id)->first();
            $receiver_id = ['company_id' => 0, 'team_id' => 0];

            if ($project->company_id != 0) {
                $receiver_id['company_id'] = $project->company_id;
            }
            if ($project->team != 0) {
                $receiver_id['team_id'] = $project->team_id;
            }
            return $receiver_id;
        }
    }

    public
    function download($id)
    {
        $message = Message::where('id', $id)
            ->where(function ($query) {
                return $query->where('sender_id', Auth::id())
                    ->orWhere('receiver_id', Auth::id());
            })
            ->first();
        return response()->download(public_path($message->attachment));

    }

    public
    function upload()
    {
        Session::forget('upload_attachment');
        $file = request()->file('file');

        $file_name = time() . '-' . $file->getClientOriginalName();
        $dir = "/uploads/message";
        $file->move(public_path($dir), $file_name);
        Session::push('upload_attachment', "{$dir}/$file_name");
    }
}
