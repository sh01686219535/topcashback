<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Advertisement;
use App\Models\Merchant;
use App\Models\RateOffModdel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdvertisementController extends Controller
{
    //payAdvertisement
    public function payAdvertisement(){
        $ratePrice = RateOffModdel::latest()->get();
        $merchant = Merchant::latest()->get();
        return view('backend.advertisement.pay-advertisement',compact('ratePrice','merchant'));
    }
    //storeAdvertisement
    public function storeAdvertisement(Request $request){
        $request->validate([
            'addLocation'=>'required',
            'price'=>'required'
            // 'merchant_id'=>'required'
        ]);
        $expiryDate = Carbon::now()->addDays(365);
        // $id = Auth::guard('admin')->user()->merchant_id;
        $advertisement = new Advertisement();
        $advertisement->addLocation = $request->addLocation;
        $advertisement->price = $request->price;
        $advertisement->merchant_id = $id;
        $advertisement->expiryDate = $expiryDate;
        $advertisement->save();

        // $dd =(Auth::guard('admin')->user()->merchant_id != 0 || Auth::guard('admin')->user()->merchant_id !='NULL');
        // dd($dd);

        // $admin = Auth::guard('admin')->user();
        $adminId =Admin::where('id',17)->first();

        if ($adminId) {
            $adminID = $adminId->id;
            // dd($adminID);
        } else {
            // Handle the case where the admin user is not authenticated.
        }

        if ($request->price)
        {
            if ($adminID) {
                $admin = Admin::find($adminID);
                $admin->balance += $request->price;
                $admin->save();
            }
        }
        return back()->with('message','Advertisement Created Successfully');
    }
    //list
    public function list(){
        $advertisement = Advertisement::latest()->get();
        return view('backend.advertisement.list',compact('advertisement'));
    }
}
