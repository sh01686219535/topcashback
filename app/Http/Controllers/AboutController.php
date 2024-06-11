<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AboutController extends Controller
{
    //about
    public function about(){
        $about = About::latest()->get();
        return view('backend.about.about',compact('about'));
    }
    //addAbout
    public function addAbout(){
        return view('backend.about.add-about');
    }
    //storeAbout
    public function storeAbout(Request $request){
        $request->validate([
            'about_itle'=>'required',
            'about_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
       $about = new About();
       $about->about_itle = $request->about_itle;
       if ($request->file('about_image')) {
        $about->about_image = $this->makeImage($request);
       }
       $about->image_description = $request->image_description;
       $about->save();
       return redirect('/about')->with('message','About Store Successfully');
    }
    // image
    private function makeImage($request){
            $image = $request->file('about_image');
            $imageName = uniqid().'.'.$image->getClientOriginalExtension();
            $directory = public_path('admin/assets/about-image');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            $thumbnail = Image::make($image);
            $thumbnail->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnail->save($directory . DIRECTORY_SEPARATOR . $imageName);
            return $imageName;
    }
    //deleteAbout
    public function deleteAbout($id)
    {
        $About = About::find($id);
    if ($About) {
    $imagePath = public_path('admin/assets/about-image/' . $About->about_image);
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    $About->delete();
    } else {
    }
        return back()->with('message','About Delete Successfully');
    }
    //editAbout
    public function editAbout($id){
        $About = About::find($id);
        return view('backend.about.edit-about',compact('About'));
    }
    //updateAbout
    public function updateAbout(Request $request){
        $About = About::find($request->About_id);
        $request->validate([
            'about_itle'=>'required',
        ]);
       $About->about_itle = $request->about_itle;
       if ($request->file('about_image')) {
        $About->about_image = $this->makeImage($request);
       }
       $About->image_description = $request->image_description;
       $About->save();
       return redirect('/about')->with('message','About Store Successfully');
    }
}
