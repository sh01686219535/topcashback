<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function privacyPolicy(){
        $privacy = PrivacyPolicy::where('id',1)->first();
        return view('backend\siteConfig\privacyPolicy\privacyPolicy',compact('privacy'));
    }
    public function storePrivacyPolicy(Request $request){
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $privacy = PrivacyPolicy::where('id',1)->first();
        // $privacy->create([
        //     'title' => request('title'),
        //     'description' => request('description')
        // ]);
        $privacy->title = $request->title;
        $privacy->description = $request->description;
        $privacy->save();
        return back()->with('success','Successfully updated');
    }
}
