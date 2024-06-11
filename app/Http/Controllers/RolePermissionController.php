<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use App\Models\SubModule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RolePermissionController extends Controller
{
    //permission
    public function permission()
    {
//        if (Auth::guard('admin')->user()->can('view-permission')) {
            $permission = Permission::latest()->get();
            return view('backend.permission.permission', compact('permission'));
//        }
//        abort(403, 'Unauthorized action.');

    }
    //addPermission
    public function addPermission(){
        $module = Module::latest()->get();
        $subModule = SubModule::latest()->get();
        return view('backend.permission.add-permission',compact('module','subModule'));
    }
    //storePermission
    //storePermission
    public function storePermission(Request $request){
        $request->validate([
            'permission_name'=>'required'
        ]);
        $permission = new Permission();
        $permission->module_id = $request->module_id;
        $permission->sub_module_id = $request->sub_module_id;
        $permission->permission_name = $request->permission_name;
        $permission->slug = Str::slug($request->permission_name);
        $permission->created_by = Auth::guard('admin')->user()->id;
        $permission->save();
        return redirect('/permission')->with('message','Permission Add Successfully');
    }
   
    //editPermission
    public function editPermission($id){
        $permission = Permission::find($id);
        $module = Module::latest()->get();
        $subModule = SubModule::latest()->get();
        return view('backend.permission.edit-permission',compact('permission','module','subModule'));
    }
    //updatePermission
    public function updatePermission(Request $request){
        $request->validate([
            'permission_name'=>'required'
        ]);
        $permission = Permission::find($request->permission_id);
        $permission->module_id = $request->module_id;
        $permission->sub_module_id = $request->sub_module_id;
        $permission->permission_name = $request->permission_name;
        $permission->slug = Str::slug($request->name, '-');
        $permission->created_by = Auth::guard('admin')->user()->id;
        $permission->save();
        return redirect('/permission')->with('message','Permission Updated Successfully');
    }
    //deletePermission
    public function deletePermission($id){
        $permission = Permission::find($id);
        $permission->delete();
        return back()->with('message','Permission Deleted Successfully');
    }

}
