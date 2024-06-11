<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    //module
    public function module(){
       if(Auth::guard('admin')->user()->can('view-module')){
            $module = Module::latest()->get();
            return view('backend.module.module',compact('module'));
       }
       abort(403, 'Unauthorized action.');
    }
    // add module
    public function addModule(){
        if(Auth::guard('admin')->user()->can('create-module')){
        return view('backend.module.add-module');
    }
    abort(403, 'Unauthorized action.');
    }
    // store module
    public function storeModule(Request $request){
        $request->validate([
            'module_name'=>'required|max:200|unique:modules'
        ]);
        $module = new Module();
        $module->module_name =$request->module_name;
        $module->slug = Str::slug($request->module_name, '-');
        $module->save();
        return redirect('/module')->with('message','Module Add Successfully');
    }
    // edit module
    public function editModule($id){
        if(Auth::guard('admin')->user()->can('edit-module')){
        $module = Module::find($id);
        return view('backend.module.edit-module',compact('module'));
    }
    abort(403, 'Unauthorized action.');
    }
    // update module

    public function updateModule(Request $request){
        $request->validate([
            'module_name'=>'required|max:200'
        ]);
        $module = Module::find($request->module_id);
        $module->module_name =$request->module_name;
        $module->slug = Str::slug($request->module_name, '-');
        $module->save();
        return redirect('/module')->with('message','Module Updated Successfully');
    }
    // delete module
    public function deleteModule($id){
        if(Auth::guard('admin')->user()->can('delete-module')){
        $module = Module::find($id);
        $module->delete();
        return back()->with('message','Module Deleted Successfully');
    }
    abort(403, 'Unauthorized action.');
    }
}
