<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    //role
    public function role(){
        if (auth('admin')->user()->can('view-role')) {
        $role = Role::latest()->get();
        return view('backend.role_permission.role',compact('role'));
    }
    abort(403, 'Unauthorized action.');
    }
    // add role blade
    public function addRole(){
        if (auth('admin')->user()->can('create-role')) {
        return view('backend.role_permission.add-role');
    }
    abort(403, 'Unauthorized action.');
    }
    // store role
    public function storeRole(Request $request){
        $request->validate([
           'role_name'=>'required|max:200|unique:roles'
        ]);
       $role = new Role();
        $role->role_name =$request->role_name;
        $role->slug = Str::slug($request->role_name, '-');
        $role->save();
        return redirect('/role')->with('message','Role Add Successfully');
    }
    // edit role
    public function editRole($id){
        if (auth('admin')->user()->can('edit-role')) {
        $role = Role::find($id);
        return view('backend.role_permission.edit-role',compact('role'));
    }
    abort(403, 'Unauthorized action.');
    }
    // update role
    public function updateRole(Request $request){
        $request->validate([
            'role_name'=>'required|max:200'
        ]);
        $role = Role::find($request->role_id);
        $role->role_name =$request->role_name;
        $role->slug = Str::slug($request->role_name, '-');
        $role->save();
        return redirect('/role')->with('message','Role Updated Successfully');
    }
    // delete role
    public function deleteRole($id){
        if (auth('admin')->user()->can('delete-role')) {
        $role = Role::find($id);
        $role->delete();
        return back()->with('message','Role deleted Successfully');
    }
    abort(403, 'Unauthorized action.');
    }
}
