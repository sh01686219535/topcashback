<?php

namespace App\Http\Controllers;

use App\Models\SiteInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SiteConfigController extends Controller
{
    // site info
    public function siteInfo(){
        if(auth('admin')->user()->can('view-siteInfo')){
        $siteInfo = SiteInfo::where('id',5)->first();

        return view('backend.siteConfig.site-info',compact('siteInfo'));
    }
    abort(403, 'Unauthorized action.');
    }
    public function siteInfoPost(Request $request){
        $request->validate([
            'company_name' => 'nullable',
            'email' => 'nullable',
            'logo' => 'nullable',
            'short_description' => 'nullable',
        ]);
        $site_id =SiteInfo::where('id',5)->first();


        $site_id->company_name = $request->company_name;
        $site_id->email = $request->email;
        $site_id->short_description = $request->short_description;
        if ($request->file('logo')){
            $site_id->logo = $this->makeImage($request);
        }

        if ($request->file('favicon')){
            $site_id->favicon = $this->makeFavicon($request);
        }
        $site_id->save();

          return back()->with('success','Successfully updated');
    }
    // image
    private function makeImage($request){
        $image = $request->file('logo');
        $imageName = rand() . '.' . $image->getClientOriginalExtension();
        $directory = public_path('admin/assets/SideInfo-image/');
        $path = 'admin/assets/SideInfo-image/';
        $imageUrl = $path . $imageName;
        $image->move($directory, $imageName);
        return $imageUrl;
    }
    private function makeFavicon($request){
        $image = $request->file('favicon');
        $imageName = rand() . '.' . $image->getClientOriginalExtension();
        $directory = public_path('admin/assets/favicon-image/');
        $path = 'admin/assets/favicon-image/';
        $imageUrl = $path . $imageName;
        $image->move($directory, $imageName);
        return $imageUrl;
    }

}
