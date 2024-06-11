<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FooterDetail;
use App\Models\Footermenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DD;
use Illuminate\Support\Str;

class FooterDetailController extends Controller
{
    public function footer_details(){
        $footerDetails = FooterDetail::all();
        $footer_menu = Footermenu::all();
        return view('backend.siteConfig.footerDetails.footerDetails',compact('footerDetails','footer_menu'));
    }
    public function showFooter_details(){
        $footer_menu = Footermenu::all();
        return view('backend.siteConfig.footerDetails.addFooterDetails',compact('footer_menu'));
    }
    public function storeFooter_details(){
        $this->validate(request(),[
            'title' => 'required',
            'description' => 'required',
        ]);
        $imageExtension = request()->file('image')->extension();
        $imageName = "photo".uniqid()."_".time().".".$imageExtension;
        request()->file('image')->move('admin\assets\footer_details',$imageName);
        FooterDetail::create([
            'footermenu_id' => request('footermenu_id'),
            'title' => request('title'),
            'description' => request('description'),
            'slug' => Str::slug(request('slug')),
            'image' => $imageName,
        ]);
        return redirect('/footer_details')->with('message','Footer Details Store Successfully');
    }

    //
    public function editEditFooter_details($id) {
        $footer_details = FooterDetail::find($id);
        $footer_menu = Footermenu::all();
        return view('backend.siteConfig.footerDetails.editFooterDetails', compact('footer_menu', 'footer_details'));
    }
    
    //updateEditFooter_details
    public function updateEditFooter_details($id){
        $this->validate(request(),[
            'title' => 'required',
            'description' => 'required',
        ]);
       
        $footer_details = FooterDetail::find($id);
        if(request()->file('image')){
            $imageExtension = request()->file('image')->extension();
            $imageName = "photo".uniqid()."_".time().".".$imageExtension;
            request()->file('image')->move('admin\assets\footer_details',$imageName);

            $footer_details->update([
                'footermenu_id' => request('footermenu_id'),
                'title' => request('title'),
                'description' => request('description'),
                'slug' => Str::slug(request('slug')),
                'image' => $imageName,
            ]);
            return redirect('/footer_details')->with('message','Footer Details Store Successfully');
        }
        
        $footer_details->update([
            'footermenu_id' => request('footermenu_id'),
            'title' => request('title'),
            'description' => request('description'),
            'slug' => Str::slug(request('slug')),
            // 'image' => $imageName,
        ]);
        return redirect('/footer_details')->with('message','Footer Details Store Successfully');
    }
    public function deleteEditFooter_details($id){
      FooterDetail::findOrFail($id)->delete();
      return redirect('/footer_details')->with('message','Footer Details delete Successfully');
    }
}
