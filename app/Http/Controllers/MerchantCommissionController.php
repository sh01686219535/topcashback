<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Offer;

use App\Models\Category;
use App\Models\Merchant;
use App\Models\Financial;
use Illuminate\Http\Request;
use App\Models\Physicallyapprove;
use App\Models\QRCode;
use Illuminate\Support\Facades\Auth;
use DB;

class MerchantCommissionController extends Controller
{
    public function showMerchantCommissionStore(){
        if(auth('admin')->user()->can('view online commi-ion merchant')){
        $qrCode = QRCode::where('status','pending')->get();
        $offer = Offer::all();
        $financial = Financial::all();
        $merchant = Merchant::all();
        $admin = Admin::all();
        $category = Category::all();
        return view('backend.commission.commissionCat',compact('financial','admin','merchant','offer','qrCode','category'));
    }
    abort(403, 'Unauthorized action.');
    }
    public function merchantCommissionStore(Request $request){
        if(auth('admin')->user()->can('view online commi-ion merchant')){
        // $fixedAmount =request('fixed_amount');
        // $percentageAmount = request('percentage_amount');
        // $merchantId = request('merchant_id');
        // $totalAmount = Offer::where('merchant_id', $merchantId)->get('id')->count();

        // $totalPercentage = Offer::where('merchant_id', $merchantId)->sum('offer_amount');


        // $percentage = ((int)$totalPercentage * (int)$percentageAmount) / 100;
        // $TotalFixedAmount = (int)$fixedAmount;
            Physicallyapprove::create([
            'merchant_id' => request('merchant_id'),
            'fixed_amount' =>request('fixed_amount'),
            'purchase_amount' => request('purchase_amount'),
            'percentage_amount' => request('percentage_amount'),
            'admin_id' => request('admin_id'),
            'offer_id'=>request('offer_id'),
            'user_id'=>request('user_id'),
            'qr_code_id'=>request('qr_code_id'),
            'receipt'=>$this->makeImage($request),
        ]);

        $qrCode = QRCode::find($request->qrCode_id);
        $qrCode->update([
            'status' => 'approved'
        ]);
        DB::commit();
        $adminID = Auth::guard('admin')->user()->id;

      if (request('fixed_amount'))
      {
          if ($adminID) {
              $admin = Admin::find($adminID);
              $admin->balance += (float)request('fixed_amount');
              $admin->save();
          }
      }else{
          if ($adminID) {
              $admin = Admin::find($adminID);
              $admin->balance += (float)request('percentage_amount');
              $admin->save();
          }
      }


        return redirect('/merchant-commission-store')->with('message','Merchant Commission Distribution Successfully');
    }
    abort(403, 'Unauthorized action.');
    }
    private function makeImage($request){

        $image = $request->file('receipt');
        $imageName = uniqid().'.'.$image->getClientOriginalExtension();
        $directory = public_path('admin/assets/purchase-invoice/');
        $path = 'admin/assets/purchase-invoice/';
        $imageUrl = $path . $imageName;
        $image->move($directory, $imageName);
        return $imageUrl;

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        $thumbnail = Image::make($image);
        $thumbnail->resize(800, 500, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumbnail->save($directory . DIRECTORY_SEPARATOR . $imageName);
        return $imageName;
    }

    //Merchant_wise_commission
    public function Merchant_wise_commission($id){
        if(auth('admin')->user()->can('approve online commi-ion merchant')){
        $someVariable = true;
        $qrCode = QrCode::find($id);
        $offer = Offer::all();
        $merchant = Merchant::all();
        $admin = Admin::all();
        return view('backend.commission.commissionCat-details',compact('admin','qrCode','offer','merchant','someVariable'));
    }
    abort(403, 'Unauthorized action.');
    }
}
