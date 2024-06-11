<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdvertiseBanner;

class AdvertiseBannerController extends Controller
{
    public function showAdvertiseBanner(){
        $AdvertiseBanner = AdvertiseBanner::where('id',1)->first();
        return view('backend.advertisement.bannerAdvertise',compact('AdvertiseBanner'));
    }
    public function advertiseBanner(Request $request){
        // $request->validate([
        //     'title' => 'required',
        //     'description' => 'required'
        // ]);
        $advertiseBanner = AdvertiseBanner::where('id',1)->first();
        // $privacy->create([
        //     'title' => request('title'),
        //     'description' => request('description')
        // ]);
        $imageExtension1 = request()->file('banner_right')->extension();
        $imageExtension2 = request()->file('banner_left')->extension();
        
       
        $imageName1 =  "photo".uniqid()."_".time()."_".".".$imageExtension1;
        $imageName2 =  "photo".uniqid()."_".time()."_".".".$imageExtension2;
        request()->file('banner_right')->move('admin\assets\advertiseBanner',$imageName1);
        request()->file('banner_left')->move('admin\assets\advertiseBanner',$imageName2);

        $advertiseBanner->banner_right = $imageName1;
        $advertiseBanner->banner_left = $imageName2;
        $advertiseBanner->bannerLinkRight = $request->bannerLinkRight;
        $advertiseBanner->bannerLinkLeft = $request->bannerLinkLeft;
        $advertiseBanner->save();
        return back()->with('success','Successfully updated');
    }
}
