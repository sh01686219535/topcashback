<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Area;
use App\Models\Merchant;
use App\Models\Offer;
use App\Models\QRCode;
use App\Models\Physicallyapprove;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Validation\Rule;
use PDF;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Milon\Barcode\QRcode as BarcodeQRcode;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use Stripe\Stripe as StripeStripe;
use Stripe;
use Session;
use Termwind\Components\Dd;


class MerchantApproveController extends Controller
{ ///show Approval
    public function showApprove()
    {
        if (auth('admin')->user()->can('View-qrcode-list')) {
            // $user = User::latest()->get();
            // $qrCode = QRCode::with('user')->get();

            // return view('backend.merchant.approved', compact('qrCode', 'user'));


            $admin = Auth::guard('admin')->user()->merchant_id == 0 || Auth::guard('admin')->user()->merchant_id == null;

            if ($admin) {
                $user = User::latest()->get();
                $qrCode = QRCode::latest()->get();

                return view('backend.merchant.approved', compact('qrCode', 'user'));
            } else {
                // $offer = Offer::latest()->all();
                $admin = Auth::guard('admin')->user();

                // if ($admin->merchant_id !== 0 && $admin->merchant_id !== null) {
                //     $id = $admin->merchant_id;
                  
                //     $offers = Offer::where('merchant_id', $id)->pluck('merchant_id');
                //     if ($offers->contains($id)) {
                //         $user = User::latest()->get();
                //         $offer_id = Offer::where('merchant_id', $id)->pluck('id');
                        
                //         $qrCode = QRCode::whereIn('offer_id', $offer_id)->get();
                //         dd($qrCode);
                //         return view('backend.merchant.approved', compact('qrCode', 'user'));
                //     }
                // } else {
                    if ($admin->merchant_id !== 0 && $admin->merchant_id !== null) {
                        $merchant_id = $admin->merchant_id;
                       
             
                        $offer_ids = Offer::where('merchant_id', $merchant_id)->pluck('merchant_id')->toArray();
    
                        $qrCode = QRCode::whereIn('merchant_id', $offer_ids)->get();
  
                        $users = User::latest()->get();
                    
                        return view('backend.merchant.approved', compact('qrCode', 'users'));
                    }else{
                    dd("Merchant ID is 0 or null.");
                }
            }


        }
        abort(403, 'Unauthorized action.');
    }
    ///PostApproval
    public function approveOffer($imageId = NULL, $status = NULL)
    {
        if (Auth::guard('admin')->check() && $imageId != NULL && $status != NULL) {
            $status = QRCode::find($imageId)->update([
                'status' => $status,
                'approved_by' => $status == 'approved' ? Auth::guard('admin')->id() : NULL,
                'approved_date' => $status == 'approved' ? date('Y-m-d H-i-s') : NULL,
            ]);
            return redirect()->back();
        } else {
            return 'Invalid response';
        }
    }
    public function showApproveUpdate()
    {
        if (auth('admin')->user()->can('view-approve_List')) {
            $qrCode = QRCode::with('admins')->get();
            $user = User::latest()->paginate(10);

            $offer = Offer::get();
            return view('backend.merchant.approved_update', compact('user', 'qrCode', 'offer'));
        }
        abort(403, 'Unauthorized action.');
    }
    //physicallyApprove

    public function showPhysicallyApprove()
    {
        if(Auth::guard('admin')->user()->can('view-phy-ically-approve')){
        $user = User::get();
        $offer = Offer::get();
        $area = Merchant::get();
        $someVariable = true;
        return view('backend.merchant.physicallyApprove', compact('offer', 'user', 'area','someVariable'));
    }
        abort(403, 'Unauthorized action.');
    }
    public function physicallyApprove(Request $request)
    {
      
        //QRCode send
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->get();
        foreach ($user as $users) {
            $name =  $users->name;
            $email =  $users->email;
        }
        $offer_id = $request->offer_id;
        $offer = Offer::where('id', $offer_id)->get();
        foreach ($offer as $value) {
            $offer_title =  $value->offer_title;
            $offer_amount =  $value->offer_amount;
            $offer_percentage =  $value->offer_percentage;
        }
        $randomString = Str::random(10);

        $purchase_amount = $request->purchase_amount;
        $percentage_amount = $request->percentage_amount;
        $qrCodeData = "Random QR code data: $randomString\n"
        ."Your Purchase Amount: $purchase_amount\n"
        . "Your Offer Id: $offer_id\n"
        . "Your Offer Title: $offer_title\n"
        . "Your Offer Percentage amount: $percentage_amount\n"
        . "Your Offer Amount: $offer_amount";
        $expiryDate = Carbon::now()->addDays(365);
        $qrCodeImage = QrCodeGenerator::size(100)->generate($qrCodeData);
        $uniqueFilename = uniqid('qr_code_');
        $qrCodeImagePath = public_path('qrcodes/' . $uniqueFilename . '.png');
        file_put_contents($qrCodeImagePath, $qrCodeImage);
        $userEmail = $email;
        $userName = $name;
        $offerTitle = $offer_title;
        $offerAmount = $offer_amount;
        $png = $qrCodeImage;
        $png = base64_encode($png);
        $qr_image = "<img src='data:image/png;base64," . $png . "'>";
        $pdf = PDF::loadView('build', [
            'qr_image' => $qr_image,
            'randomString' => $randomString,
            'offerTitle' => $offerTitle,
            'offerAmount' => $offerAmount

        ])->setPaper(array(0, 0, 200, 360));
        $data = ['name' => $userName, 'email' => $userEmail, 'offer_title' => $offerTitle, 'offer_amount' => $offerAmount];
        Mail::send('mail', $data, function ($message) use ($data, $pdf) {
            $message->from('support@topcashbackadmin.icicle.dev', 'Admin');
            $message->to($data['email'], $data['name'], $data['offer_title'], $data['offer_amount'])

                ->subject('Cash Back Offer')
                ->attachData($pdf->output(), "qrcode.pdf");
        });
        $merchant_id =  $request->merchant_id;
        $offer_amount =  $request->offer_amount;
        $qrCode = QRCode::create([
            'qr_code'=>$randomString,
            'qr_code_data' => $qrCodeData,
            'user_email' => $userEmail,
            'sent_email' => false,
            'merchant_id' => $merchant_id,
            'status' => 'approve',
            'expiry_date' => $expiryDate,
            'user_id' => request('user_id'),
            'offer_id' => request('offer_id'),
            'offer_title' => $offerTitle,
            'offer_amount' => $offer_amount,
            'purchase_amount' => $purchase_amount,
            'percentage_amount' => $percentage_amount,
        ]);
        $qrCode->update(['sent_email' => true]);
        return to_route('verification',$qrCode->id)->with('message','QRCode Successfully');
    }
    public function showVerification($id){
        $user = User::all();
        $offer = Offer::find($id);
        $merchant = Merchant::all();
        $qrCode = QRCode::find($id);
        $area = Area::find($id);
        return view('backend.merchant.verification',compact('qrCode','user','offer','area','merchant'));
    }

    // store verification

    public function verification(Request $request,$id){
        $offer_id = $request->offer_id;
        $qr_code = $request->qr_code;
        $user_id = $request->user_id;
        $offer_title = $request->offer_title;
        $merchant_id = $request->merchant_id;
        $purchase_amount = $request->purchase_amount;
        $percentage_amount = $request->percentage_amount;
        $fixed_amount = $request->fixed_amount;
        $receipt = $request->file('receipt');
        $merchant = Merchant::all();
        $qrCode = QRCode::find($id);

        Physicallyapprove::create([
            'user_id' => $user_id,
            'merchant_id' => $merchant_id,
            'fixed_amount' =>$fixed_amount,
            'percentage_amount' => $percentage_amount,
            'qr_code_id' => $qr_code,
            'offer_id' => $offer_id,
            'receipt' => $this->makeImage($request),
            // 'receipt' => request('receipt'),
            'purchase_amount' => $purchase_amount,
        ]);

        $qrCode = QRCode::find($id);
        $qrCode->update([
            'status' => 'approved'
        ]);

        return view('backend.payment.phy-stripe',compact('percentage_amount','qrCode','merchant','receipt','fixed_amount','offer_title','merchant_id','purchase_amount','user_id','offer_id','qr_code'));
    }
    public function verificationPayment(Request $request,$id){

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

          DB::commit();
        //   $adminID = Auth::guard('admin')->user()->merchant_id == 0 || Auth::guard('admin')->user()->merchant_id == null;
        $adminID = Admin::where('merchant_id', 0)
             ->orWhereNull('merchant_id')
                ->select('id')
                ->get();   

        if (request('fixed_amount'))
        {
            // dd($adminID);
            if ($adminID) {
                $admin = Admin::find($adminID);
                foreach ($admin as $value) {
                    $value->balance += (float)request('fixed_amount'); 
                }
                // $admin->balance += (float)request('fixed_amount'); // Assuming $adminCommission holds the updated balance
                $value->save();
            }
        }else{
            if ($adminID) {
                $admin = Admin::find($adminID);
                foreach ($admin as $value) {
                    $value->balance += (float)request('percentage_amount'); 
                }
                $value->save();
            }
        }
        return redirect('/physicallyApprove')->with('message','Merchant Commission Distribution and Payment Successfully');
    }
    private function makeImage($request){
        $image = $request->file('receipt');
        $imageName = uniqid().'.'.$image->extension();
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
}
