<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use App\Models\Task;
use App\Models\TaskMaster;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();

        $userId = Auth::id();

        // $usr= Auth::user();

        // $projects = Project::whereRaw("JSON_SEARCH(team_ids, 'one', ?) IS NOT NULL", [$userId])
        // ->orderBy('created_at', 'desc')
        // ->get();

        $projects = Project::orderBy('created_at', 'desc')->when(['users'])->get();

        $customerRole = Role::where('name', 'Customer')->first();
        
        $clients = User::where('role', $customerRole->id)->get();

        $excludeRoleIds = Role::whereIn('name', ['Admin', 'Super Admin'])->pluck('id')->toArray();

        $users = User::whereNotIn('role', $excludeRoleIds)->get();

        $customerRoleId = $customerRole->id;

        
        $tasks = Task::where('assign_to', $userId)->get();

        $taskList=TaskMaster::get();

        return view('projects.index', compact('request', 'users', 'roles', 'projects', 'clients', 'customerRoleId','tasks','taskList'));
    }

    public function create(Request $request)
    {
        $roles = Role::all();

        $projects = Project::orderBy('created_at', 'desc')->get();

        $customerRole = Role::where('name', 'Customer')->first();
        $clients = User::where('role', $customerRole->id)->get();

        $excludeRoleIds = Role::whereIn('name', ['Admin', 'Super Admin'])->pluck('id')->toArray();

        $users = User::whereNotIn('role', $excludeRoleIds)->get();

        $customerRoleId = $customerRole->id;

        return view('projects.create', compact('request', 'users', 'roles', 'projects', 'clients', 'customerRoleId'));
    }


    public function store(Request $request)
    {

        $params['name'] = $request->name;
        $params['role'] = $request->role;
        $params['email'] = $request->email;
        $params['phone'] = $request->phone;
        $params['dob'] = $request->dob;
        $params['password'] = bcrypt($request->password);
        $user=User::create($params);
        $user->assignRole($request->role);
        return back()->with('success', 'Client Create successfully.');
    }

    public function project_store(Request $request)
    {
        
        $params = [
            'name' => $request->input('name'),
            'start_date' => $request->input('start_date'),
            'deadline' => $request->input('deadline'),
            'status' => $request->input('status'),
        ];

        if ($request->has('multi_ids')) {
            $params['multi_ids'] = json_encode($request->input('multi_ids'));
        }

        if ($request->has('team_ids')) {
            $params['team_ids'] = json_encode($request->input('team_ids'));
        }

        Project::create($params);

        return redirect('projects')->with('success', 'Project Created Successfully');
    }



    public function edit(Request $request)
    {
       
        $id=$request->id;
        $projects= Project::find($id);

         $roles = Role::all();

        $customerRole = Role::where('name', 'Customer')->first();
        $clients = User::where('role', $customerRole->id)->get();

        $excludeRoleIds = Role::whereIn('name', ['Admin', 'Super Admin'])->pluck('id')->toArray();

        $users = User::whereNotIn('role', $excludeRoleIds)->get();

        $customerRoleId = $customerRole->id;

        // $view = view('projects.edit', compact('request', 'users', 'roles', 'projects', 'clients', 'customerRoleId'))->render();

        return response()->json($projects);
    }

    public function edit_status(Request $request)
    {
        $customerRole   = Role::where('name', 'Customer')->first();

        $clients        = User::where('role', $customerRole->id)->get();

        $excludeRoleIds = Role::whereIn('name', ['Admin', 'Super Admin'])->pluck('id')->toArray();

        $users          = User::whereNotIn('role', $excludeRoleIds)->get();

        $view['team_drop'] = view('projects.team_drop', compact('users', 'request'))->render();

        return $view;
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $projects= Project::find($id);

        $params = [
            'name' => $request->input('name'),
            'start_date' => $request->input('start_date'),
            'deadline' => $request->input('deadline'),
            'status' => $request->input('status'),
        ];

        if ($request->has('multi_ids')) {
            $params['multi_ids'] = json_encode($request->input('multi_ids'));
        }

        if ($request->has('team_ids')) {
            $params['team_ids'] = json_encode($request->input('team_ids'));
        }

        $projects->update($params);

        return redirect('projects')->with('success', 'Project updated successfully.'); 
    }

    public function task_done($id)
    {
        $project = Project::find($id);

        $data = [
            'mark_done' => 1, 
        ];

        $project->update($data);

        return response()->json(['success' => 'project Mark As Completed','data'=>$project]);
    }


    public function task_undone($id)
    {
        $project = Project::find($id);

        $data = [
            'mark_done' => 0, 
        ];

        $project->update($data);

        return response()->json(['success' => 'project Mark As Not Completed','data'=>$project]);
    }


    

    public function delete($id)
    {
        
        $tasks=Task::where('project_id',$id)->get();

        $tasks->delete();

        $projects= Project::find($id);

        $projects->delete();

        return response()->json(['success' => 'project deleted successfully']);

    }

    public function task_store(Request $request, $id)
    { 
        
        $params['project_id'] =$id;
        $params['title'] =$request->title;
        $params['start_date'] =$request->start_date;
        $params['end_date'] =$request->end_date;
        $params['assign_to'] =$request->assign_to;
        $params['cost'] =$request->cost; 
        $params['currency']=$request->currency;

        Task::create($params);

        return back()->with('success', 'Task Created Successfully');     

    }

    public function task_list(Request $request, $id)
    {
        $id = decrypt($id);
        $tasks = Task::where('project_id', $id)->get();
        $project = Project::find($id);
        return view('projects.project_details', compact('tasks','project'));     
    }



    public function task_update(Request $request, $id)
    {
        

        $tasks= Task::find($id);

        $data = [
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'assign_to' => $request->assign_to,
            'cost' => $request->cost,
            'currency'=> $request->currency,
        ];

        $tasks->update($data);

        return back()->with('success', 'Task updated successfully.'); 
    }

    public function tasks_done($id)
    {
        $tasks= Task::find($id);

        $data = [
            'mark_done' => 1, 
        ];

        $tasks->update($data);

        return response()->json(['success' => 'Task Mark Done successfully','data'=>$tasks]);
    }

    public function tasks_undone($id)
    {
        $tasks= Task::find($id);

        $data = [
            'mark_done' => 0, 
        ];

        $tasks->update($data);

        return response()->json(['success' => 'Task Mark Un-Done successfully','data'=>$tasks]); 

    }


    public function tasks_delete($id)
    {

        $tasks = Task::find($id);

        $tasks->delete();

        return response()->json(['success' => 'Task deleted successfully']);

    }


    public function comment_store(Request $request)
    {
        $params['user_id']      = Auth::user()->id;
        $params['task_id']   = $request->tid;
        $params['comments']     = $request->cmt;
        $res = Comment::create($params);
        if($res){
            return 'true';
        } else {
            return 'false';
        }
    }
  
    public function comment_get(Request $request)
    {
        $tid = $request->tid;
        $data['comments'] = Comment::where('task_id',$tid)->orderby('id','desc')->get();
        $view = view('projects.comments',$data)->render();
        return $view;
    }

    public function document_store(Request $request)
    {

       $request->validate([
                'tid'=>'required',
            ]);

        $params['user_id']      = Auth::user()->id;
        $params['task_id']   = $request->tid;

        if ($request->hasFile('file')) 
        {

            $file = $request->file('file');

            // Check the file type (PDF or image)
            // $allowedMimeTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/gif'];
            
            // if (in_array($file->getMimeType(), $allowedMimeTypes)) {}
            $fileName = $file->getClientOriginalName();

            $file-> move(public_path('/document/'), $fileName); 

            $params['document']     = $fileName;
       
        }

        $res = Comment::create($params);

        if($res){
            return response()->json(['success'=>'document Upload']);
        } else {
            return response()->json(['error'=>'document Not Upload']);
        }
    }


    public function Docs_get(Request $request)
    {

        $tid = $request->tid;
        $data['comments'] = Comment::where('task_id',$tid)->whereNotNull('document')->orderby('id','desc')->get();
        $view = view('projects.documents',$data)->render();
        return $view;
    }

    public function DownloadImage($imageFileName)
    {
        $path = public_path('/document/' . $imageFileName);
        
        return response()->download($path);
    }


}
