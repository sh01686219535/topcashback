<?php

namespace App\Http\Controllers;

use App\Models\Footermenu;
use Illuminate\Http\Request;

class FootermenuController extends Controller
{
    //footerMenu
    public function footerMenu(){
        $footerMenu = Footermenu::latest()->get();
        return view('backend.siteConfig.footerMenu.menu',compact('footerMenu'));
    }
    //addfooterMenu
    public function addfooterMenu(){
        return view('backend.siteConfig.footerMenu.add-menu');
    }
    //storeMenu
    public function storeMenu(Request $request){
        $request->validate([
            'footer_menu'=>'required'
        ]);
       $menu = new Footermenu();
       $menu->footer_menu = $request->footer_menu;
       $menu->save();
       return redirect('/footer-menu')->with('message','Footer Menu Store Successfully');
    }
    //editMenu
    public function editMenu($id){
        $footerMenu = Footermenu::find($id);
    return view('backend.siteConfig.footerMenu.edit-menu',compact('footerMenu'));
    }
    //updateMenu
    public function updateMenu(Request $request){
        $menu = Footermenu::find($request->menu_id);
        $request->validate([
            'footer_menu'=>'required'
        ]);
       $menu->footer_menu = $request->footer_menu;
       $menu->save();
       return redirect('/footer-menu')->with('message','Footer Menu Update Successfully');
    }
   //deleteMenu
   public function deleteMenu($id)
   {
       $menu = Footermenu::find($id);
       $menu->delete();
       return back()->with('message','Footer Menu Delete Successfully');
   }


}
