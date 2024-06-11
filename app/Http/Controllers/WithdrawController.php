<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    //payWithdraw
    public function payWithdraw(){
        return view('backend.withdraw.withdraw');
    }
    //pay
    public function pay(Request $request){
        \Stripe\Stripe::setApiKey('sk_test_51MPr7VSBCXsdwl0NEY0lHhYTLgifE4dp5yQeZPeREm2PI5tJ9rfp5ZN0gj8Cka6laqiFmNUF75xRYhl8IYiKCFEJ00sEwdbS1A');
          $balance = Admin::all();
          foreach ($balance as $item){
              $session = \Stripe\Checkout\Session::create([
                  'payment_method_types' => ['card'],
                  'line_items' => [
                      [
                          'price_data' => [
                              'currency' => 'usd', // Replace with the appropriate currency code
                              'unit_amount' => $item->balance, // Replace with the price in cents
                              'product_data' => [
                                  'name' => 'Withdraw Amount', // Replace with your product name
                                   // Replace with your product description
                              ],
                          ],
                          'quantity' => 1, // Adjust the quantity as needed
                      ],
                  ],
                  'mode' => 'payment',
                  'success_url' => 'http://localhost:8000/success',
                  'cancel_url' => 'http://localhost:8000/cancel',
              ]);

              return redirect($session->url);

          }
    }
}
