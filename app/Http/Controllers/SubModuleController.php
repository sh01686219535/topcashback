<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\SubModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubModuleController extends Controller
{
    //sub Module
    public function subModule(){
       if(Auth::guard('admin')->user()->can('view-sub-module')) {
            $subModule = SubModule::all();
            return view('backend.subModule.subModule', compact('subModule'));
       }
       abort(403, 'Unauthorized action.');
    }
    // add subModule
    public function addSubModule(){
        if(Auth::guard('admin')->user()->can('create-sub-module')) {
        $module = Module::latest()->get();
        return view('backend.subModule.add-subModule',compact('module'));
    }
    abort(403, 'Unauthorized action.');
    }

    // store sub module
    public function storeSubModule(Request $request){
        $request->validate([
            'module_id'=>'required',
            'subModule_name'=>'required|max:200|unique:sub_modules'
        ]);
        $subModule = new SubModule();
        $subModule->module_id = $request->module_id;
        $subModule->subModule_name = $request->subModule_name;
        $subModule->slug = Str::slug($request->subModule_name,'-');
        $subModule->save();
        return redirect('/subModule')->with('message','Sub Module Add Successfully');
    }
    // edit sub module
    public function editSubModule($id){
        if(Auth::guard('admin')->user()->can('edit-sub-module')) {
        $module = Module::latest()->get();
        $subModule= SubModule::find($id);
        return view('backend.subModule.edit-subModule',compact('subModule','module'));
    }
    abort(403, 'Unauthorized action.');
    }
    // update Sub Module
    public function updateSubModule(Request $request){
        $request->validate([
            'module_id'=>'required',
            'subModule_name'=>'required|max:200'
        ]);
        $subModule= SubModule::find($request->subModule_id);
        $subModule->module_id = $request->module_id;
        $subModule->subModule_name = $request->subModule_name;
        $subModule->slug = Str::slug($request->subModule_name,'-');
        $subModule->save();
        return redirect('/subModule')->with('message','Sub Module Update Successfully');
    }
    // delete Sub Module
    public function deleteSubModule($id){
        if(Auth::guard('admin')->user()->can('delete-sub-module')) {
        $subModule= SubModule::find($id);
        $subModule->delete();
        return back()->with('message','Sub Module Deleted Successfully');
    }
    abort(403, 'Unauthorized action.');
    }
}
