<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    //merchantArea
    public function merchantArea(){
        if(auth('admin')->user()->can('view-merchant-area')){
        $area = Area::latest()->get();
        return view('backend.merchantArea.area',compact('area'));
    }
    abort(403, 'Unauthorized action.');
    }
    //addArea
    public function addArea(){
        if(auth('admin')->user()->can('create-merchant-area')){
        return view('backend.merchantArea.add-area');
    }
    abort(403, 'Unauthorized action.');
    }
    //storeArea
    public function storeArea(Request $request){

        $request->validate([
            'areaName'=>'required'
        ]);
        $area = new Area();
        $area->areaName = $request->areaName;
        $area->save();
        return redirect('/merchant-area')->with('message','Area Store Successfully');
    }
    //editArea
    public function editArea($id){
        if(auth('admin')->user()->can('edit-merchant-area')){
        $area = Area::find($id);
        return view('backend.merchantArea.edit-area',compact('area'));
    }
    abort(403, 'Unauthorized action.');
    }
    //updateArea
    public function updateArea(Request $request){
        $area = Area::find($request->area_id);
        $request->validate([
            'areaName'=>'required'
        ]);
        $area->areaName = $request->areaName;
        $area->save();
        return redirect('/merchant-area')->with('message','Area Update Successfully');
    }
    //deleteArea
    public function deleteArea($id){
        if(auth('admin')->user()->can('delete-merchant-area')){
        $area = Area::find($id);
        $area->delete();
        return back()->with('message','Area Deleted Successfully');
    }
    abort(403, 'Unauthorized action.');
    }

}
