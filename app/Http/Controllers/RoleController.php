<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    
    public function index(Request $request)
    {
        $roles = Role::all(); 
        return view('role.index', compact('roles','request'));
    }

   
    public function create()
    {
       return view('role.create');
    }

    
    public function store(Request $request)
    {
        $params['name'] = $request->name;
        Role::create($params);
        return redirect('roles')->with('success', 'Roles Create successfully.');
    }

    
    public function show(string $id)
    {
        //
    }

   

    public function edit($id)
    {
        $id=decrypt($id);
        $role= Role::find($id);

        return view('role.edit',compact('role'));
    }

   
   
    public function update(Request $request, $id)
    {
       
        $role= Role::find($id);

        $data = [
            'name' => $request->name,
        ];

        $role->update($data);

        return redirect('roles')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function delete($id)
    {
        $id=decrypt($id);

        $role=Role::find($id);

        $role->delete();

        return redirect('roles')->with('error','Role deleted successfully.');
    }


    public function role_permissions($id)
    {
        $id=decrypt($id);
        $dats = Role::where('roles.id', $id)
                ->with('permissions')
                ->first();
        $data['dats'] = $dats;
        $permissionIds = [];
        if($dats['permissions']){
            foreach ($dats['permissions'] as $key => $value) {
                array_push($permissionIds, $value->id);
            }
        }
         // return $permissionIds;
        $data['permissionIds'] = $permissionIds;

        $role_permission = \DB::table('permissions')->get();

        $custom_permission = array();

        foreach($role_permission as $per){

            $key = substr($per->name, 0, strpos($per->name, ".")); 

            if(str_starts_with($per->name, $key)){
                $custom_permission[$key][] = $per;
            }
            
        }
        // return $custom_permission;
        $data['custom_permission'] = $custom_permission;

        return view('role.permissions',$data);
    }

    public function update_assign_permission(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
        ]);

        $role = Role::find($request->role_id);

        $role->save();

        $role->syncPermissions($request->permissions);

        return redirect('roles')->with('success','Role update successfully.');
    }

}
