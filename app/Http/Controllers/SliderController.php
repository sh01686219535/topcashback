<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    //slider
    public function slider(){
        if(auth('admin')->user()->can('view-slider')){
        $slider = Slider::latest()->get();
        return view('backend.siteConfig.slider.slider',compact('slider'));
    }
    abort(403, 'Unauthorized action.');
    }
    // add slider
    public function addSlider(){
        if(auth('admin')->user()->can('create-slider')){
        return view('backend.siteConfig.slider.add-slider');
    }
    abort(403, 'Unauthorized action.');
    }
    // store slider
    public function storeSlider(Request $request){
        $request->validate([
           'position'=>'required',
           'image'=>'nullable',
        ]);
        $slider = new Slider();
        $slider->position = $request->position;
        if ($request->file('image')){
            $slider->image = $this->makeImage($request);
        }
        $slider->save();
        return to_route('slider')->with('message','Slider Store Successfully');
    }
    // image
    private function makeImage($request){
        //
        // $image = $request->file('offer_image');
        // $imageName = rand() . '.' . $image->getClientOriginalExtension();
        // $directory = public_path('admin/assets/offer-image/');
        // $path = 'admin/assets/offer-image/';
        // $imageUrl = $path . $imageName;
        // $image->move($directory, $imageName);
        // return $imageUrl;
        //
        $image = $request->file('image');
        $imageName = uniqid().'.'.$image->getClientOriginalExtension();
        $directory = public_path('admin/assets/slider-image/');
        $path = 'admin/assets/slider-image/';
        $imageUrl = $path . $imageName;
        $image->move($directory, $imageName);
        return $imageUrl;


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
    // edit slider
    public function editSlider($id){
        if(auth('admin')->user()->can('edit-slider')){
        $slider = Slider::find($id);
        return view('backend.siteConfig.slider.edit-slider',compact('slider'));
    }
    abort(403, 'Unauthorized action.');
    }
    // update slider
    public function updateSlider(Request $request){
        $request->validate([
            'position'=>'required',
            'image'=>'nullable',
        ]);
        $slider = Slider::find($request->slider_id);
        $slider->position = $request->position;
        if ($request->file('image')){
            $slider->image = $this->makeImage($request);
        }
        $slider->save();
        return to_route('slider')->with('message','Slider Updated Successfully');
    }
    // delete slider
    public function deleteSlider($id){
        // if(auth('admin')->user()->can('delete-slider')){
        $slider = Slider::findOrFail($id);
        if ($slider) {
            $imagePath = public_path('admin/assets/slider-image/'.$slider->image);
         if (file_exists($imagePath)) {
             unlink($imagePath);
         }
         $slider->delete();
         } else {
         }
         return back()->with('message','Slider Deleted Successfully');
    // abort(403, 'Unauthorized action.');
    }
}
