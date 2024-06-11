<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Merchant;
use App\Models\MerchantAdvertisement;
use App\Models\RateOfPrice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe;
use Session;
use Termwind\Components\Dd;

class MerchantAdvertisementController extends Controller
{
      //merchantAdvertisement

      public function merchantAdvertisement(){
        if(auth('admin')->user()->can('view-pay-advertisement')){
        $merchantAdd = MerchantAdvertisement::latest()->get();
        return view('backend.merchantAdvertisement.merchant-advertisement',compact('merchantAdd'));
    }
    abort(403, 'Unauthorized action.');
    }

   //addMerchantRate
   public function addMerchantRate(){
    if(auth('admin')->user()->can('create-pay-advertisement')){
    if (!Auth::guard('admin')->user()) {
        return back()->with('message','You have no permission');
    }else{
        $rate = RateOfPrice::all();
        $admin = Auth::guard('admin')->user();
        $merchant = Merchant::all(); // Initialize $merchant with a default value

        if ($admin->merchant_id !== 0 && $admin->merchant_id !== null) {
            $id = $admin->merchant_id;
            $merchant = Merchant::where('id', $id)->get();
        }
        return view('backend.merchantAdvertisement.add-merchant-advertisement', compact('rate', 'merchant'));
    }
    abort(403, 'Unauthorized action.');
}
}
    //saveMerchantRate
    public function saveMerchantRate(Request $request){
        $placeName = $request->placeName;
        $ratePlace = $request->ratePlace;
        $merchant_id = $request->merchant_id;
        return view('backend.merchantAdvertisement.details',compact('placeName','ratePlace','merchant_id'));
    }
//     public function paymentMerchantAdd(Request $request){
//         $ratePlace = $request->ratePlace;
//         // Stripe\Stripe::setApiKey(env('STRIPE_SCRIPT_KEY'));
//         // Stripe\Charge::create ([
//         //         "amount" => $ratePlace * 100,
//         //         "currency" => "usd",
//         //         "source" => $request->stripeToken,
//         //         "description" => "Making test payment." 
//         // ]);
//      // Convert to integer and then multiply by 100
// if ($ratePlace < 0) {
    
//     // Handle case where the amount is less than 1 USD (100 cents)
//     // You might set a default value or throw an error to prompt the user to enter a valid amount
// } else {
    
//     \Stripe\Stripe::setApiKey(env('STRIPE_SCRIPT_KEY'));

//     try {
//         \Stripe\Charge::create([
//             "amount" => $ratePlace,
//             "currency" => "usd",
//             "source" => $request->stripeToken,
//             "description" => "Making test payment.",
           
//         ]);
      
//         // Add further logic for successful charge creation
//     } catch (\Stripe\Exception\CardException $e) {
        
//         // Handle failed card charge
//     } catch (\Stripe\Exception\InvalidRequestException $e) {
//         // Handle invalid request
//     } catch (\Stripe\Exception\AuthenticationException $e) {
//         // Handle authentication error
//     } catch (\Stripe\Exception\ApiConnectionException $e) {
//         // Handle API connection error
//     } catch (\Stripe\Exception\ApiErrorException $e) {
//         // Handle generic API error
//         // dd($e->getMessage());
//         // dd($ratePlace);
//     }
// }


//         $expiryDate = Carbon::now()->addDays(365);
//        $request->validate([
//            'placeName'=>'required',
//            'ratePlace'=>'required',
//            'merchant_id'=>'required',
//        ]);
//        $merchantAdd = new MerchantAdvertisement();
//        $merchantAdd->expiryDate = $expiryDate;
//        $merchantAdd->placeName = $request->placeName;
//        $merchantAdd->ratePlace = $request->ratePlace;
//        $merchantAdd->merchant_id = $request->merchant_id;
//        $merchantAdd->save();

//        $adminId =Admin::where('id',17)->first();
//        if ($adminId) {
//            $adminID = $adminId->id;
//            // dd($adminID);
//        } else {
//            // Handle the case where the admin user is not authenticated.
//        }
//        $ratePlace = $request->ratePlace;
//        // dd($ratePlace);
//        if ($ratePlace)
//        {
//            if ($adminID) {
//                $admin = Admin::find($adminID);
//                $admin->balance += $ratePlace;
//                $admin->save();
//            }
//        }

//        return redirect('/merchant-advertisement')->with('message','Merchant Addvertisement Rate Add & Payment Successfully');
//    }
public function paymentMerchantAdd(Request $request){
    \Stripe\Stripe::setApiKey(env('STRIPE_SCRIPT_KEY'));
    $ratePlace = $request->ratePlace;
   
    if ($ratePlace >= 1) {
        try {
            \Stripe\Charge::create([
                "amount" => $ratePlace, // Convert to cents
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Making test payment.",
            ]);
            // Add further logic for successful charge creation
        } catch (\Stripe\Exception\CardException $e) {
            // Handle failed card charge
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Handle invalid request
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Handle authentication error
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Handle API connection error
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle generic API error
        }
    }
    $expiryDate = Carbon::now()->addDays(365);
    $merchantAdd = new MerchantAdvertisement();
    $merchantAdd->expiryDate = $expiryDate;
    $merchantAdd->placeName = $request->placeName;
    $merchantAdd->ratePlace = $ratePlace; 
    $merchantAdd->merchant_id = $request->merchant_id;
    $merchantAdd->save();
    $adminId = Admin::where('id', 17)->first();
    if ($adminId) {
        $adminID = $adminId->id;
        if ($adminID) {
            $admin = Admin::find($adminID);
            $admin->balance += $ratePlace;
            $admin->save();
        }
    }
    return redirect('/merchant-advertisement')->with('message', 'Merchant Advertisement Rate Added & Payment Successfully');
}

    //editMerchantRate
    public function editMerchantRate($id){
        if(auth('admin')->user()->can('edit-pay-advertisement')){
        $merchant = MerchantAdvertisement::find($id);
        $rate = RateOfPrice::all();
        return view('backend.merchantAdvertisement.edit-merchant-advertisement',compact('merchant','rate'));
    }
    abort(403, 'Unauthorized action.');
}
    //updateMerchantRate
    public function updateMerchantRate(Request $request){
       $request->validate([
           'placeName'=>'required',
           'ratePlace'=>'required',
       ]);
       $merchantAdd = MerchantAdvertisement::find($request->merchant_rate);
       $merchantAdd->placeName = $request->placeName;
       $merchantAdd->ratePlace = $request->ratePlace;
       $merchantAdd->save();
       return redirect('/merchant-advertisement')->with('message','Merchant Addvertisement Rate Update Successfully');
   }
   //deleteMerchantRate
   public function deleteMerchantRate($id){
    if(auth('admin')->user()->can('delete-pay-advertiement')){
    $merchantAdd = MerchantAdvertisement::find($id);
    $merchantAdd->delete();
    return redirect('/merchant-advertisement')->with('message','Merchant Addvertisement Rate Delete Successfully');
   }
   abort(403, 'Unauthorized action.');
}
}
