<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function showSocialLinks(){
        $social_links = SocialLink::all();
        return view('backend.siteConfig.socialLinks.socialLinks',compact('social_links'));
    }
    public function addSocialLinks(){

        return view('backend.siteConfig.socialLinks.addSocialLinks');
    }
    public function socialLinks(Request $request){
        $social_links = new SocialLink();
        $this->validate(request(), [
            'social_name' => 'required',
            'social_links' => 'required',
            'social_logo' => 'required|image',
        ]);



        $social_links->create([
            'social_name' => request('social_name'),
            'social_logo' => $request->hasFile('social_logo') ? $this->makeImage($request) : \request('social_logo'),
            // 'social_logo' => $this->makeImage($request),
            'social_links' => request('social_links'),
        ]);

        return redirect()->route('showSocialLinks');
    }
    private function makeImage($request){
        $imageExtension = $request->file('social_logo')->extension();
        $imageName = "photo" . uniqid() . "_" . time() . "." . $imageExtension;
        $image = Image::make(request()->file('social_logo'));
        $image->resize(30, 30, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save(public_path('admin/assets/social_icons/' . $imageName));
        return $imageName;
    }
    public function showEditSocialLinks($id){
        $social_links = SocialLink::find($id);
        return view('backend.siteConfig.socialLinks.edit SocialLinks',compact('social_links'));
    }
    public function editSocialLinks(Request $request,$id){
        $this->validate(request(),[
            'social_name' => 'required',
            'social_links' => 'required',
        ]);

        $social_links = SocialLink::find($id);
        // $imageExtension = request()->file('social_logo')->extension();
        // $imageName = "photo".uniqid()."_".time().".".$imageExtension;
        // request()->file('social_logo')->move('admin\assets\social_icons',$imageName);

        $social_links->update([
            'social_name' => request('social_name'),
            'social_logo' => $request->hasFile('social_logo') ? $this->makeImage($request) : \request('social_logo'),
            // 'social_logo' => $this->makeImage($request),
            'social_links' => request('social_links'),
        ]);
        return to_route('showSocialLinks');
    }
    public function showDeleteSocialLinks($id){
        SocialLink::findOrFail($id)->delete();
        return redirect()->back();
    }

}
