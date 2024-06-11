<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Merchant;

class MerchantAuthController extends Controller
{

  public function register(){
         Merchant::create([
             'merchant_name' => request('namerchant_nameme'),
             'merchant_email' => request('merchant_email'),
             'merchant_password' => bcrypt(request('merchant_password')),
             'merchant_confirm_password' => bcrypt(request('merchant_confirm_password')),
         ]);
         return to_route('dashboard');
     }




}
