<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\Offer;
use App\Models\Physicallyapprove;
use App\Models\QRCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CommissionService;
use DB;

class CommissionController extends Controller
{
    //

    public function showCommission(){
        if(auth('admin')->user()->can('view online commi-ion category')){
            $qrCode = QRCode::where('status','pending')->get();
        $offer = Offer::all();
        $financial = Financial::all();
        $merchant = Merchant::all();
        $admin = Admin::all();
        $category = Category::all();
        // $offer = Offer::all();
        // $financial = Financial::all();
        // $merchant = Merchant::all();

        // $admin = Admin::all();
        // $category = Category::all()->unique('category_name');
        return view('backend.commission.commission',compact('financial','admin','merchant','offer','qrCode','category'));
    }
    abort(403, 'Unauthorized action.');
    }

    public function calculateAndDistributeCommission(Request $request)
    {
        if(auth('admin')->user()->can('view online commi-ion category')){
        // $fixedAmount =request('fixed_amount');
        // $percentageAmount = request('percentage_amount');
        // $merchantId = request('merchant_id');
        // $offer_id = request('offer_id');
        // // dd($offer_id);
        // $totalAmount = Offer::where('id', $offer_id)->get('id')->count();
        // // dd($totalAmount);
        // $totalPercentage = Offer::where('brand_name', $merchantId)->sum('offer_amount');
        // $percentage = ($totalPercentage * $percentageAmount) / 100;
        // $TotalFixedAmount = $totalAmount * $fixedAmount;

        //     Physicallyapprove::create([
        //     'merchant_id' => request('merchant_id'),
        //     'fixed_amount' =>$TotalFixedAmount,
        //     'percentage_amount' => $percentage,
        //     'admin_id' => request('admin_id'),
        //     'offer_id' => request('offer_id')
        // ]);

        //   $adminID = Auth::guard('admin')->user()->id;

        // // Update admin's balance
        // if ($TotalFixedAmount)
        // {
        //     if ($adminID) {
        //         $admin = Admin::find($adminID);
        //         $admin->balance += $TotalFixedAmount; // Assuming $adminCommission holds the updated balance
        //         $admin->save();
        //     }
        // }else{
        //     if ($adminID) {
        //         $admin = Admin::find($adminID);
        //         $admin->balance += $percentage; // Assuming $adminCommission holds the updated balance
        //         $admin->save();
        //     }
        // }

        // return back()->with('message','Merchant Commission Distribution Successfully');
        Physicallyapprove::create([
            'offer_id' => request('offer_id'),
            'fixed_amount' =>request('fixed_amount'),
            'purchase_amount' => request('purchase_amount'),
            'percentage_amount' => request('percentage_amount'),
            'admin_id' => request('admin_id'),
            'offer_id'=>request('offer_id'),
            'user_id'=>request('user_id'),
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


        return redirect('/commission')->with('message','Merchant Commission Distribution Successfully');
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
    public function showCommissionDetails($id){

        if(auth('admin')->user()->can('approve online commi-ion category')){
        $someVariable = true;
        $qrCode = QrCode::find($id);
        $offer = Offer::all();
        $merchant = Merchant::all();
        $admin = Admin::all();

         return view('backend.commission.commissionDetails',compact('admin','qrCode','offer','merchant','someVariable'));
        }
        abort(403, 'Unauthorized action.');
    }


}
