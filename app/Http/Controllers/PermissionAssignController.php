<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Module;
use App\Models\PermissionAssign;
use Illuminate\Http\Request;

class PermissionAssignController extends Controller
{
    public function showAccessControl(){
        // if (auth('admin')->user()->can('view-permission')) {
        $role = Role::select('id', 'role_name')->paginate(10);
        // $permissionss = Permission::with('roles')->latest()->get();
        $rol = Role::latest()->paginate(10);
        $permissionAssign = PermissionAssign::latest()->paginate(10);
        $assign = PermissionAssign::latest()->paginate(10);


        return view('backend.permissionAssign.permissionAssign',compact('permissionAssign','rol','assign','role'));
    // }
    // abort(403, 'Unauthorized action.');
    }
    public function addAssignPermission(){
        // if (auth('admin')->user()->can('create-permission')) {
        $module = Module::all();
        $permission = Permission::latest()->paginate(10);
        $rol = Role::latest()->paginate(10);
        $permissionAssign = PermissionAssign::latest()->paginate(10);

        // dd($assign);
//        $permission_groups = Admin::getpermissionGroup();
        return view('backend.permissionAssign.add-permissionAssign',compact('permission','rol','permissionAssign','module'));
    // }
    // abort(403, 'Unauthorized action.');
    }
    public function accessControl(Request $request)
    {

        foreach($request->permission_id as $permission){
            $permissionAssign = new PermissionAssign();
            $permissionAssign->role_id = $request->role_id;
            $permissionAssign->permission_id =$permission;
            $permissionAssign->save();
        }
        return redirect('/access-control')->with('message','Assign Permission Add Successfully');

    }
    public function showEditAssignPermission($id){

        // $permissionAssign=PermissionAssign::where('role_id',$id)->get();
        $role=Role::get();
        $roleToEdit = Role::find($id);
        $module=Module::get();
        $permarray=array();
        $permissionAssign=PermissionAssign::where('role_id',$id)->get();
        foreach($permissionAssign as $perms){
            $permarray[]=$perms->role_id;
        }

        return view('backend.permissionAssign.editPermissionAssign', compact('id','module', 'permissionAssign', 'permarray', 'role','roleToEdit'));

    }
    public function editAssignPermission(Request $request)
    {
        // if (auth('admin')->user()->can('edit-permission')) {
        $check=PermissionAssign::where('role_id',$request->permission_assign_id)->first();
        if($check)
        {
            PermissionAssign::where('role_id',$request->role_id)->delete();
            foreach($request->permission_id as $permission){
                $permissionAssign = new PermissionAssign();
                $permissionAssign->role_id = $request->role_id;
                $permissionAssign->permission_id =$permission;
                $permissionAssign->save();
            }
            return redirect('/access-control')->with('message','Assign Permission Update Successfully');
        }
    // }
    // abort(403, 'Unauthorized action.');

    }
    //deleteAssignPermission

    public function deleteAssignPermission($id){
        if (auth('admin')->user()->can('edit-permission')) {
        try {
           PermissionAssign::where('role_id',$id)->delete();
        } catch (\Exception $ex) {
            return back()->with(['status' => false, 'error' =>$ex->getMessage()]);
        }
        return back()->with(['status' => true, 'success' => 'Data Deleted Successfully']);
    }
    abort(403, 'Unauthorized action.');
    }

}
