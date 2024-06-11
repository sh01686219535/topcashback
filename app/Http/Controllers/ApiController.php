<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Banner;
use App\Models\Offer;
use App\Models\QRCode;
use App\Models\TearmsCondition;
use App\Models\SiteInfo;
use App\Models\Slider;
use App\Models\Category;
use App\Models\About;
use App\Models\Area;
use App\Models\Currency;
use App\Models\Merchant;
use App\Models\SocialLink;
use App\Models\PrivacyPolicy;
use App\Models\CustomerService;
use App\Models\FooterDetail;
use App\Models\Footermenu;
use App\Models\MerchantAdvertisement;
use App\Models\Role;
use App\Models\RateOffModdel;
use App\Models\RateOfPrice;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;

class ApiController extends Controller
{
    //category
    public function category()
    {
        $category = Category::select('id', 'category_name')->with('subCategory')->get();
        return response()->json($category, 200);
    }
    //subcategory
    public function subCategory()
    {
        $subCategory = SubCategory::all();
        return response()->json($subCategory, 200);
    }
    //offer
    public function offer()
    {

        $offers = Offer::with('merchant', 'category', 'subCategory','advertisement'
        )
        ->where('status', true)
        ->select('id','placeName','category_id','subCategory_id','offer_title','offer_amount','offer_percentage','offer_description','merchant_id','offer_image','affiliate_url')
        ->get();
        return response()->json(['offer' => $offers], 200);

    }
    //User registration

    public function userRegister()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required',
            // 'confirm_password' => 'required|same:password|min:7',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'address' => request('address'),
            'security_question' => request('security_question'),
            'security_answer' => request('security_answer'),
            'password' => bcrypt(request('password')),

        ]);
        return response()->json([
            'status' => 'ok',
            'message' => 'User CReated'
        ]);
    }
    //User Login
    public function userLogin()
    {
        $credentials = request()->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = JWTAuth::user(); // Retrieve the authenticated user

if ($user) {
    // If the user is authenticated, select specific columns in the query
    $userData = User::select('id', 'name', 'phone', 'email', 'balance', 'address')->find($user->id);

    // Check if the selected data is not empty
    if ($userData) {
        $cookie = cookie('jwt', $token, 60 * 24);
        return response()->json([
            'status' => 'ok',
            'token' => $token,
            'user' => $userData,
        ])->withCookie($cookie);
    } else {
        return response()->json(['error' => 'User not found or has missing columns.'], 404);
    }
} else {

    return response()->json(['error' => 'Unauthorized.'], 401);
}


    }



    //Merchant
    public function merchant()
    {
        $merchant = Merchant::select('id','merchant_image')->get();
        return response()->json($merchant, 200);
    }
    //Currency
    public function currency()
    {
        $currency = Currency::all();
        return response()->json($currency, 200);
    }
    public function latestOffer()
    {
        $latestOffer = Offer::select(
            'id',
            'offer_title',
            'offer_amount',
            'offer_percentage',
            'offer_description',
            'merchant_id',
            'offer_image',
            'created_at'
        )->latest()->get();
        return response()->json($latestOffer, 200);
    }
    public function whatsNew()
    {
        // Retrieve a random offer
        $whatsNew = Offer::select(
            'id',
            'offer_title',
            'offer_amount',
            'offer_percentage',
            'offer_description',
            'merchant_id',
            'offer_image',
            'created_at'
        )->latest()->get();

        // Combine the latest offer and the random offer


        return response()->json($whatsNew, 200);
    }
    public function topToday()
    {
        $featured = Offer::select(
            'id',
            'offer_title',
            'offer_amount',
            'offer_percentage',
            'offer_description',
            'merchant_id',
            'offer_image',
            'created_at',
            'status'
        )
            ->latest()
            ->get();
        return response()->json($featured, 200);
    }
    public function trendingOffer()
    {
        $featured = Offer::select(
            'id',
            'offer_title',
            'offer_amount',
            'offer_percentage',
            'offer_description',
            'merchant_id',
            'offer_image',
            'created_at',
            'status'
        )
            ->inRandomOrder()
            ->latest()
            ->get();
        return response()->json($featured, 200);
    }
    public function recentlyAddedStore(){
        $recentlyAddedStore = MerchantAdvertisement::where('status', 'approved')
    ->with('merchant:id,merchant_image,company_name,created_at') // Specify the necessary columns from the merchant table
    ->get();
        return response()->json($recentlyAddedStore, 200);
    }

    public function slider()
    {
        $slider = Slider::all();
        return response()->json($slider, 200);
    }
    public function offerDetailsPage($id)
    {
        $allOffers = Offer::find($id);
        return response()->json($allOffers, 200);
    }
    public function getRelatedOffers($offer_id)
    {
        try {
            // Fetch the category of the given offer
            $category = DB::table('offers')->where('id', $offer_id)->value('category_id');

            // Fetch related offers with the same category
            $relatedOffers = DB::table('offers')->where('category_id', $category)->where('id', '!=', $offer_id)->get();

            return response()->json($relatedOffers);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function Category_subCategory($id)
    {
        $Subcategory = SubCategory::with('offer')->find($id);
        // $categories = Category::all();
        return response()->json($Subcategory, 200);
    }
    public function Category_subCategory_offer($id)
    {
        $Category = Category::with('offer')->find($id);
        // $categories = Category::all();
        return response()->json($Category, 200);
    }
    //banner
    public function banner()
    {
        $banner = Banner::all();
        return response()->json($banner, 200);
    }
    public function sitInfo()
    {
        $siteInfo = SiteInfo::all();
        return response()->json($siteInfo, 200);
    }
    public function userProfile(){
        $user = JWTAuth::user();
        $userData = User::select('id', 'name')->find($user->id);
        return response()->json($userData, 200);
    }
    public function profile(){
        $user = JWTAuth::user();
        if ($user) {
            $userData = User::select('id', 'name', 'phone', 'email', 'balance', 'address')->find($user->id);
            $user->update([
                'name' => request('name'),
                'security_question' => request('security_question'),
                'security_answer' => request('security_answer'),
            ]);
            return response()->json([
                'status' => 'ok',
                'message' => 'Profile Updated',
                'userUpdated'=> $userData

            ],200);
        } else {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
    }
    //area
    public function allArea()
    {
        $area = Area::all();
        return response()->json($area, 200);
    }
    //merchantRegistration
    public function merchantRegistration(Request $request)
    {


        Merchant::create([
            'merchant_name' => \request('merchant_name'),
            'merchant_number' => \request('merchant_number'),
            'merchant_email' => \request('merchant_email'),
            'area' => \request('area'),
            'company_name' => \request('company_name'),
            'merchant_password' => bcrypt(request('merchant_password')),
            'postcode' => request('postcode'),
            'city' => $request->input('city') ?? null,
            'latitude' => $request->input('latitude') ?? null,
            'longitude' => $request->input('longitude') ?? null,

            // 'roles' =>
        ])->financial()->create();
        $mid = Merchant::all()->last()->id;

        $admin = Admin::create([
            'name' => $request->merchant_name,
            'email' => $request->merchant_email,
            'password' => bcrypt($request->merchant_password),
            'merchant_id' => $mid,
        ]);

        $role_id = Role::where('role_name', 'Merchant')->first();
        $admin->roles()->attach($role_id->id);
        return response()->json([
            'status' => 'ok',
            'message' => 'User CReated'
        ]);

        // try {
        //     $data = [];
        //     $data['merchant_name'] = $request->merchant_name;
        //     $data['merchant_email'] = $request->merchant_email;
        //     $data['merchant_number'] = $request->merchant_number;
        //     $data['address'] = $request->address;
        //     $data['merchant_password'] = bcrypt($request->merchant_password);
        //     $data['company_name'] = $request->company_name;
        //     $data['latitude'] = $request->latitude;
        //     $data['longitude'] = $request->longitude;
        //    Merchant::create($data);
        //    $mid= Merchant::all()->last()->id;

        //    $admin = Admin::create([
        //     'name' => $request->merchant_name,
        //     'email' => $request->merchant_email,
        //     'password' => bcrypt($request->merchant_password),
        //     'merchant_id' =>$mid,
        // ]);
        // $admin->roles()->attach('3');
        // } catch (\Exception $ex) {
        //     return response()->json(['status' => false, 'msg' => $ex->getMessage()]);
        // }
        // return response()->json(['status' => true, 'msg' => 'Data Updated Successfully']);
    }

    public function merchantLogin()

    {
        $credentials = request()->only('merchant_email', 'merchant_password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json([
            'status' => 'ok',
            'token' => $token
        ]);
        // $credentials = request()->only('merchant_email', 'merchant_password');

        // if (Auth::attempt($credentials)) {
        //     $email = request()->input('merchant_email');
        //     // Authentication passed
        //     $users = Merchant::select('id', 'merchant_name', 'merchant_email', 'email_verified_at', 'address', 'merchant_number', 'company_name','latitude','longitude')->where('merchant_email',$email)->get();
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'User data retrieved successfully',
        //         'users' => $users,
        //     ], 200);
        // } else {
        //     // Authentication failed
        //     return response()->json(['message' => 'Login failed'], 401);
        // }


    }
    public function qrCodeSend(Request $request)
    {
        // try {
            $user = JWTAuth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Retrieve the offer from the database
            $offer = DB::table('offers')->where('id', $request->offer_id)->first();

        //    $clicks = DB::table('offers')->where('id', $offer->id)->get();
        //    $clicks->increment('clicks');

            // Check if the offer exists
            if (!$offer) {
                return response()->json(['error' => 'Offer not found'], 404);
            }
            // Extract user details
            $name = $user->name;
            $email = $user->email;

            // Extract offer details
            $offer_title = $offer->offer_title;
            $offer_amount = $offer->offer_amount;
            $offer_percentage = $offer->offer_percentage;
            $merchant_id = $offer->merchant_id;
            // Generate a random QR code data
            $offer_id = $request->offer_id;
            $expiryDate = Carbon::now()->addDays(365);
            $randomString = Str::random(10);
            $qrCodeData = 'Random QR code data: ' . $randomString . $offer_id;

            // Generate QR code image
            $qrCodeImage = QrCodeGenerator::size(100)->generate($qrCodeData);

            // Save the QR code image to a file
            $uniqueFilename = uniqid('qr_code_');
            $qrCodeImagePath = public_path('qrcodes/' . $uniqueFilename . '.png');
            file_put_contents($qrCodeImagePath, $qrCodeImage);

            // Prepare data for email
            $userName = $name;
            $offerTitle = $offer_title;
            $offerAmount = $offer_amount;
            $png = base64_encode($qrCodeImage);
            $qr_image = "<img src='data:image/png;base64," . $png . "'>";

            // Create a PDF with the QR code image
            $pdf = PDF::loadView('build', [
                'qr_image' => $qr_image,
                'randomString' => $randomString,
                'offerTitle' => $offerTitle,
                'offerAmount' =>$offerAmount,
            ])->setPaper(array(0, 0, 200, 360));

            // Send the email with the PDF attachment
            $data = ['name' => $userName, 'email' => $email, 'offer_title' => $offerTitle, 'offer_amount' => $offerAmount];
            Mail::send('mail', $data, function ($message) use ($data, $pdf) {
                $message->from('support@topcashbackadmin.icicle.dev', 'Admin');
                $message->to($data['email'], $data['name'])
                    ->subject('Cash Back Offer')
                    ->attachData($pdf->output(), "qrcode.pdf");
            });

            // Create and store the QR code record in the database
            QRCode::create([
                'qr_code'=> $randomString,
                'qr_code_data' => $qrCodeData,
                'user_email' => $email,
                'sent_email' => true,
                'status' => 'pending',
                'expiry_date' => $expiryDate,
                'user_id' => $user->id,
                'merchant_id' => $merchant_id,
                'offer_id' => $offer_id,
                'offer_title' => $offerTitle,
                'offer_amount' => $offerAmount,
                'percentage_amount' => $offer_percentage,
            ]);


            return response()->json(['message' => 'Mail sent with QR code Successfully']);

        // } catch (Exception $e) {
        //     // Log the error for debugging
        //     \Log::error($e);
        //     return response()->json(['error' => 'Internal Server Error'], 500);
        // }
    }
    //payoutDashboard
    public function payoutDashboard()
    {
        try {
            $user = JWTAuth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            // $payouts = Payout::where('user_id', $user->id)->select('payouts.id', 'payouts.user_id', 'payouts.amount')
            // ->sum('amount');

            $userData = User::select('id', 'name', 'balance')->find($user->id);
            // $payoutPending = Payout::selectRaw('SUM(amount) as total_pending')
            // ->where('user_id', $user->id)
            // ->where('status', 'pending')
            // ->first();

            $userBalance = $userData->balance;
            // Calculate the sum of paid payouts
            $paidPayouts = Payout::where('user_id', $user->id)
                ->where('status', 'approve')
                ->sum('amount');

            // Calculate the sum of pending payouts
            $pendingPayouts = Payout::where('user_id', $user->id)
                ->where('status', 'pending')
                ->sum('amount');

            // Calculate the total sum
            $totalAmount =  $paidPayouts + $pendingPayouts;

            return response()->json(['user' => $userData, 'paid_amount' => $paidPayouts,'pending'=> $pendingPayouts,'Total_Amount'=>$totalAmount], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function userPendingTotalAmount()
    {
        try {
            $user = JWTAuth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $payouts = Payout::selectRaw('SUM(amount) as total_pending')
                ->where('user_id', $user->id)
                ->where('status', 'pending')
                ->first();

            $userData = User::select('id', 'name', 'balance')->find($user->id);

            return response()->json(['user' => $userData, 'payouts' => $payouts], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    // count merchant wise offer
    public function countOffersByMerchant(Request $request)
    {
        // Customize the limit as needed
        $limit = $request->input('limit', 10);

        $offerCounts = Offer::leftJoin('offers', 'merchants.id', '=', 'offers.merchant_id')
            ->select('merchants.name', DB::raw('COUNT(offers.id) as offer_count'))
            ->groupBy('merchants.id')
            ->orderBy('offer_count', 'desc')
            ->limit($limit)
            ->get();

        return response()->json($offerCounts);
    }
    //userEarning

    public function userEarning()
    {
        try {

            $user = JWTAuth::user();
            if (!$user) {
                Log::info('User not authenticated');
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $payouts = Payout::with(['merchant:id,merchant_name,company_name,merchant_image', 'offer:id,offer_title'])
            ->where('user_id',$user->id)
            ->select('merchant_id', 'offer_id', 'amount', 'status', 'created_at', 'updated_at')
            ->get();



            $userData = User::select('id', 'name', 'balance')->find($user->id);

            return response()->json(['user' => $userData, 'payouts' => $payouts], 200);
        } catch (Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
     //userEarningConfirm
     public function userEarningConfirm(){
        try {
            $user = JWTAuth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $payouts = Payout::selectRaw('SUM(amount) as total_pending')
                ->where('user_id', $user->id)
                ->where('status', 'approve')
                ->first();

            $userData = User::select('id', 'name', 'balance')->find($user->id);

            return response()->json(['user' => $userData, 'payouts' => $payouts], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
     //userEarningPending
     public function userEarningDeclined(){
        try {
            $user = JWTAuth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $payouts = Payout::selectRaw('SUM(amount) as total_pending')
                ->where('user_id', $user->id)
                ->where('status', 'declined')
                ->first();

            $userData = User::select('id', 'name', 'balance')->find($user->id);

            return response()->json(['user' => $userData, 'payouts' => $payouts], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    //userEarningPending
    public function userEarningPending(){
        try {

            $user = JWTAuth::user();
            if (!$user) {
                Log::info('User not authenticated');
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $payouts = Payout::with(['merchant:id,merchant_name,company_name,merchant_image', 'offer:id,offer_title'])
            ->where('user_id',$user->id)
            ->where('status','pending')
            ->select('merchant_id', 'offer_id', 'amount', 'status', 'created_at', 'updated_at')
            ->get();

            $userData = User::select('id', 'name', 'balance')->find($user->id);

            return response()->json(['user' => $userData, 'payouts' => $payouts], 200);
        } catch (Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function payout(Request $request)
    {
        // Validate the request data (you can adjust the validation rules

        try {
            // Attempt to authenticate the user using the JWT token
            $user = JWTAuth::parseToken()->authenticate();

            // Find the authenticated user
            $targetUser = User::find($user->id);

            if (!$targetUser) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $balance = $targetUser->balance;
            $minimumBalanceLimit = 2;

            if ($balance >= 3) {
                $withdrawAmount = $balance - $minimumBalanceLimit;
                $newBalance = $balance - $withdrawAmount;

                // Create a payout record for the target user
                $targetUser->payouts()->create([
                    'amount' => $withdrawAmount,
                    'status' => 'pending'
                ]);

                // Update the target user's balance
                $targetUser->update([
                    'balance' => $newBalance
                ]);

                // Return payout information as JSON response
                return response()->json([
                    'message' => 'Payout successful',
                    'user_id' => $targetUser->id, // Include user ID in the response
                    'withdraw_amount' => $withdrawAmount
                ], 200);
            } else {
                return response()->json(['error' => 'Insufficient balance'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    //customer_service
    public function customer_service(){
        $customer = CustomerService::create([
            'issue' => request('issue'),
            'retailer_name' => request('retailer_name'),
            'date_time' => request('date_time'),
            'offer_type' => request('offer_type'),
            'purchase_amount' => request('purchase_amount'),
            'confirm_number' => request('confirm_number'),
            'discount_coupon' => request('discount_coupon'),
            'check_in' => request('check_in'),
            'check_out' => request('check_out'),
            'status' => request('status'),
        ]);
        return response()->json([
            'status' => 'ok',
            'customer_service' => $customer
        ]);
    }
    public function privacyPolicy(){
        $privacy = PrivacyPolicy::all();
        return response()->json($privacy, 200);
    }
    public function terms(){
        $terms = TearmsCondition::all();
        return response()->json($terms, 200);
    }
    public function rateOfPrice(){
        $rate = RateOfPrice::all();
        return response()->json($rate, 200);
    }
    public function about(){
        $about = About::all();
        return response()->json($about, 200);
    }
    public function socialLinks(){
        $social = SocialLink::all();
        return response()->json($social, 200);
    }
    //menuFooter
    public function menuFooter(){
        $footerMenu = Footermenu::all();
        return response()->json($footerMenu, 200);
    }
    //footerDetails
    public function footerDetails(){
        $footerDetails = FooterDetail::all();
        return response()->json($footerDetails, 200);
    }
    //profileProgress
    public function profileProgress(){
        try {
            $user = JWTAuth::user();
            $profileCompletion = $this->calculateProfileCompletion($user);
            return response()->json([
                'userProfileBar' => $profileCompletion,
            ], 200);
        }catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    private function calculateProfileCompletion($user)
    {
        $profileFields = ['name', 'email', 'phone','password','confirm_password','address','security_question','security_answer'];
        $completedFields = 0;

        foreach ($profileFields as $field) {
            if (!empty($user->$field)) {
                $completedFields++;
            }
        }
        // Calculate the percentage
        $profileCompletionPercentage = ($completedFields / count($profileFields)) * 100;

        return round($profileCompletionPercentage, 2);
    }
    //clicks
    public function clicks()
    {
        $mostClickedProduct = Offer::orderByDesc('clicks')
        ->first();

    return response()->json(['most_clicked_product' => $mostClickedProduct]);
    }
}
