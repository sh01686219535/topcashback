<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\QRCode;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //merchantSearch
  public function merchantSearch(Request $request){
        $merchant = Merchant::where('merchant_name','like','%'.$request->merchant_serch.'%')
        ->orWhere('merchant_email','like','%'.$request->merchant_serch.'%')
        ->orWhere('city','like','%'.$request->merchant_serch.'%')
        ->orWhere('merchant_number','like','%'.$request->merchant_serch.'%')
        ->orWhere('merchant_secondary_number','like','%'.$request->merchant_serch.'%')
        ->orWhere('address','like','%'.$request->merchant_serch.'%')
        ->orWhere('company_name','like','%'.$request->merchant_serch.'%')
        ->orWhere('postcode','like','%'.$request->merchant_serch.'%')
        // ->orWhere('area ','like','%'.$request->merchant_serch.'%')
        ->orderBy('id','desc')
        ->paginate(8);
        if ($merchant->count() >= 1) {
            return view('backend.merchant.merchant', compact('merchant'))->render();
        }else{
            return response()->json([
                'status'=> 'Nothing Fount'
            ]);
        }

    }
    //qrCodeSearch
    public function qrCodeSearch(Request $request){
        $qrCode = $request->qrCode_serch;
        $qrCode = QRCode::where('qr_code_data','like','%'.$qrCode.'%')
        ->orWhere('expiry_date','like','%'.$qrCode.'%')
        ->orWhere('created_at','like','%'.$qrCode.'%')
        ->orderBy('id','desc')
        ->paginate(8);
        $user = User::latest()->get();
        if ($qrCode->count() >= 1 && $user->count() >= 1) {
            return view('backend.merchant.approved', compact('qrCode','user'))->render();
        }else{
            return response()->json([
                'status'=> 'Nothing Fount'
            ]);
        }

    }
}
