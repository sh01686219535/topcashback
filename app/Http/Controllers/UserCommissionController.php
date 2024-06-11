<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Merchant;
use App\Models\Offer;
use App\Models\Physicallyapprove;
use App\Models\UserCommission;
use App\Models\User;
use App\Models\Qrcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class UserCommissionController extends Controller
{
      //Commission List
      public function showCommissionList(){
        $physicallyApprove = Physicallyapprove::where('status','pending')->get();

        return view('backend.userCommission.pendingList',compact('physicallyApprove'));
    }
    public function showUserCommission($id){
        $admin = Admin::where('merchant_id', '0')
        ->orWhereNull('merchant_id')
        ->get();
        // dd($admin);
        $offer = Offer::all();

//        $user = Qrcode::select('user_id', 'id')
//            ->with('user')
//            ->get();
        $uniqueUsers = DB::table('qrcodes')
            ->join('users', 'qrcodes.user_id', '=', 'users.id')
            ->select('users.id', 'users.name')
            ->distinct()
            ->get();
        $merchant = Merchant::all();
        $physicallyApprove = Physicallyapprove::find($id);
        // dd($physicallyApprove[0]->admin_id);
        return view('backend.userCommission.userCommission',compact('admin','offer','uniqueUsers','physicallyApprove','merchant'));
    }
    public function userCommissionStore(Request $request,$id){
        $physicallyApprove = Physicallyapprove::find($id);
        // dd($physicallyApprove);
        $percentage_amount = $request->percentage_amount;
        $fixed_amount = $request->fixed_amount;
        $user_id = $request->user_id;
        $offer_title_id = $request->offer_title_id;
        $percentage_amount_1 = $request->percentage_amount_1;
        $user = User::all();
        $offer = Offer::all();
        return view('backend.payment.userPayment',compact('offer','physicallyApprove','user','percentage_amount','fixed_amount','user_id','offer_title_id','percentage_amount_1'));
    }


    public function userPayment(Request $request,$id){

        $fixed_amount = $request->fixed_amount;
        $percentage_amount = $request->percentage_amount;
        if ($fixed_amount) {
            if ($fixed_amount >= 1) {
            } else {
                \Stripe\Stripe::setApiKey(env('STRIPE_SCRIPT_KEY'));
                try {
                    \Stripe\Charge::create([
                        // dd($fixed_amount),
                        "amount" => $fixed_amount * 100, 
                        "currency" => "usd",
                        "source" => $request->stripeToken,
                        "description" => "Making test payment.",
                    ]);
                    
                } catch (\Stripe\Exception\CardException $e) {
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                } catch (\Stripe\Exception\AuthenticationException $e) {
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                } catch (\Stripe\Exception\ApiErrorException $e) {
                }
            }
        }elseif ($percentage_amount) {
            if ($percentage_amount < 0) {
            } else {
                \Stripe\Stripe::setApiKey(env('STRIPE_SCRIPT_KEY'));
                try {
                    \Stripe\Charge::create([
                        "amount" => $percentage_amount * 100, // Convert to cents
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
        }
        DB::beginTransaction(); 
        try {
            UserCommission::create([
                'fixed_amount' => $request->fixed_amount,
                'percentage_amount' => $request->percentage_amount,
                // 'admin_id' => $request->admin_id,
                'user_id' => $request->user_id,
                'offer_title_id' => $request->offer_title_id,
            ]);
            
            $physicallyA = Physicallyapprove::find($id);
            $physicallyA->update([
                'status' => 'approved'
            ]);
            $adminID = Auth::guard('admin')->user()->id;
            if ($adminID) {
                $admin = Admin::find($adminID);
                $admin->balance -= (float)$request->fixed_amount;
                $admin->balance -= (float)$request->percentage_amount;
                $admin->save();
            }
            $user_phone = $request->user_id;
            $user = User::where('id',$user_phone)->get();
            foreach ($user as $users) {
                $user_id = $users->id;
                if ($user_id) {
                    $user = User::find($user_id);
                    $user->balance += (float)$request->fixed_amount;
                    $user->balance += (float)$request->percentage_amount;
                    $user->save();
                }
            }
            DB::commit();
            return redirect('/list-commission')->with('message', 'Commission added successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/list-commission')->with('error', 'An error occurred while adding commission');
        }
    }

}
