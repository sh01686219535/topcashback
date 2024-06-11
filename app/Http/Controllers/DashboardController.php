<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Merchant;
use App\Models\Offer;
use App\Models\QRCode;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // if (auth('admin')->user()->can('View Da-hboard')) {
        $totalOffers = Offer::count();
        $totalClient = User::count();
        $totalMerchant = Merchant::count();

        $today = Carbon::now()->format('Y-m-d');

        // Count QRCode records created today
        $todaysQrCodeCount = QRCode::whereDate('created_at', $today)->count();
        return view('backend.admin.dashboard',compact('totalOffers','totalClient','totalMerchant','todaysQrCodeCount'));
    }
    // abort(403, 'Unauthorized action.');
    // }

}
