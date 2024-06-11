<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Models\RateOfPrice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RateOffPlaceController extends Controller
{
    //
    public function rateOffPlace(){
       $ratePlace = RateOfPrice::all();
       return view('backend.rateOffPlace.rate',compact('ratePlace'));
    }
    //addRate
    public function addRate(){
        $merchant = Merchant::latest()->get();
        return view('backend.rateOffPlace.add-rate',compact('merchant'));
    }
    //storeRateOffPlace
    public function storeRateOffPlace(Request $request){
        // $expiryDate = Carbon::now()->addDays(365);
        // $id = Auth::guard('admin')->user()->merchant_id;
       $rate = new RateOfPrice();
       $rate->placeName = $request->placeName;
    //    $rate->expiryDate = $expiryDate;
    //    $rate->merchant_id = $request->merchant_id;
       $rate->ratePlace = $request->ratePlace;
       $rate->save();
       return redirect('/rate-off-place')->with('message','Rate Off Place Add Successfully');
    }
    //editRate
    public function editRate($id){
        $rate = RateOfPrice::find($id);
        $merchant = Merchant::latest()->get();
        return view('backend.rateOffPlace.edit-rate',compact('rate','merchant'));
    }
    //deleteRate
    public function deleteRate($id){
        $rate = RateOfPrice::find($id);
        $rate->delete();
        return back()->with('message','Rate Off Place Delete Successfully');
    }
    //UpdateRateOffPlace
    public function UpdateRateOffPlace(Request $request){
        $rate = RateOfPrice::find($request->rate_id);
        $rate->placeName = $request->placeName;
        // $rate->merchant_id = $request->merchant_id;
        $rate->ratePlace = $request->ratePlace;
        $rate->save();
        return redirect('/rate-off-place')->with('message','Rate Off Place Update Successfully');
    }
}
