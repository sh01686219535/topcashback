<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use Illuminate\Http\Request;

class PayoutDashboardController extends Controller
{
    public function showPayoutDashboard(){
        $payouts = Payout::with('user')
            ->where('status','pending')
            ->paginate(30);
       
        return view('backend.payout.payoutDashboard',compact('payouts'));
    }
    public function approvePayout($payoutId= null, $status= null){
        Payout::findOrFail($payoutId)->update([
            'status' => $status,
        ]);
        return redirect()->back();
    
    }
}
