<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function showPayout(){
        if (auth('admin')->user()->can('view-payout')) {
            // Retrieve a list of user IDs
    $userIds = [1]; // Replace with the IDs you want to fetch

    // Retrieve user balances for the specified IDs
        $userBalances = User::whereIn('id', $userIds)->pluck('balance', 'id');
        return view('backend.payout.payout',['userBalances' => $userBalances]);
    }
    abort(403, 'Unauthorized action.');
    }

    

    public function payout(){
        $userIds = [1];
        $userBalances = User::whereIn('id', $userIds)->pluck('balance', 'id');

        foreach ($userBalances as $userId => $balance) {
            if ($balance >= 3) {
                $minimumBalanceLimit = 2;
                $withdrawAmount = (int)$balance-$minimumBalanceLimit;

                $newBalance = $balance - $withdrawAmount;

                // Create a payout record for this user
                User::find($userId)->payouts()->create([
                    'amount' => $withdrawAmount,
                    'status' => 'pending'
                ]);

                // Update the user's balance
                User::where('id', $userId)->update([
                    'balance' => $newBalance
                ]);
            } else {
                return "Hacker Detected";
            }
        }

        return redirect()->back();
    }

}
