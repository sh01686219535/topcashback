<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Offer;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    // banner
    public function banner(){
        if(auth('admin')->user()->can('view-banner')){
        $banner = Banner::latest()->get();
      
        return view('backend.siteConfig.banner.banner',compact('banner'));
    }
    abort(403, 'Unauthorized action.');
    }
    //add banner
    public function addBanner(){
        if(auth('admin')->user()->can('create-banner')){
        return view('backend.siteConfig.banner.add-banner');
    }
    abort(403, 'Unauthorized action.');
    }
    // store banner
    public function storeBanner(Request $request){
        $request->validate([
            'banner_position'=>'required',
            'banner_image'=>'nullable',
        ]);
        $banner = new Banner();
        $banner->banner_position = $request->banner_position;
        if ($request->file('banner_image')){
            $banner->banner_image = $this->makeImage($request);
        }
        $banner->save();

        return redirect('/banner')->with('message','Banner Store Successfully');
    }
    // image
    private function makeImage($request){
        $image = $request->file('banner_image');
        $imageName = uniqid().'.'.$image->getClientOriginalExtension();
        $directory = public_path('admin/assets/banner-image/');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        $thumbnail = Image::make($image);
        $thumbnail->resize(800, 500, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumbnail->save($directory . DIRECTORY_SEPARATOR . $imageName);

        return $imageName;
    }
    //banner edit
    public function editBanner($id){
        if(auth('admin')->user()->can('edit-banner')){
        $banner = banner::find($id);
        return view('backend.siteConfig.banner.edit-banner',compact('banner'));
        }
        abort(403, 'Unauthorized action.');
    }
    // delete banner
    public function deleteBanner($id){

        if(auth('admin')->user()->can('delete-banner')){
        $banner = Banner::find($id);
        if ($banner) {
            $imagePath = public_path('admin/assets/banner-image/'.$banner->banner_image);
         if (file_exists($imagePath)) {
             unlink($imagePath);
         }
         $banner->delete();
         } else {
         }

        return back()->with('message','Banner Deleted Successfully');
    }
    abort(403, 'Unauthorized action.');
    }
    // update banner
    public function updateBanner(Request $request){
        $request->validate([
            'banner_position'=>'required',
            'banner_image'=>'nullable',
        ]);
        $banner = Banner::find($request->banner_id);
        $banner->banner_position = $request->banner_position;
        if ($request->file('banner_image')){
            $banner->banner_image = $this->makeImage($request);
        }
        $banner->save();
        return to_route('banner')->with('message','Banner Store Successfully');
    }

}
