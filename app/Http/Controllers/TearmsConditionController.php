<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TearmsCondition;
use Illuminate\Http\Request;

class TearmsConditionController extends Controller
{
    public function termsConditions(){
        $terms = TearmsCondition::where('id',1)->first();
        return view('backend.siteConfig.termsConditions.termsConditions',compact('terms'));
    }
    public function storeTermsConditions(Request $request){
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $terms = TearmsCondition::where('id',1)->first();
        // $privacy->create([
        //     'title' => request('title'),
        //     'description' => request('description')
        // ]);
        $terms->title = $request->title;
        $terms->description = $request->description;
        $terms->save();
        return back()->with('success','Successfully updated');
    }
}
