<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\TaskMaster;

class TaskController extends Controller
{
    
        /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    { 

        $tasks=TaskMaster::orderby('id','desc')->paginate(10);
        return view('task.index',compact('tasks'));
         
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {   
        

    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {

        $params['title']=$request->title;
        TaskMaster::create($params);

        return back()->with('success','Task Added Successfully');
        
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function show(Company $company)
    {
        

    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
    public function edit(Request $request)
    {
        $id=$request->input('task_id');
        $task=TaskMaster::find($id)
        ->update([
            'title'=>$request->input('title'),
        ]);
         
        return back()->with('success','Task Edit Successfully');

    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Company $company)
    {
        


    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
    public function delete($id)
    {

     $tasks=TaskMaster::find($id);
     $tasks->delete();
     return back()->with('success','Task delete Successfully');   


    }

   public function getState(Request $request)
    {
        


    }
    public function getCity(Request $request)
    {
        


    }

}
