<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Merchant;
use App\Models\MerchantAdvertisement;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\User;
use App\Models\RateOffModel;
use App\Models\Physicallyapprove;
use App\Models\QRCode;
use App\Models\RateOfPrice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DefaultController extends Controller
{
    //
    public function getCategory(Request $request){
        $category_id = $request->post('category_id');
        $subCategory = DB::table('sub_categories')->where('category_id', $category_id)->get();
        $html = '<option value="">Select A Sub Category</option>';
        foreach ($subCategory as $item){
            $html .= '<option value="'.$item->id.'">'.$item->sub_category_name.'</option>';
        }
        return response()->json($html);
    }
    public function getMerchantName(Request $request){
        $category_id = $request->post('category_id_1');
        $Category = DB::table('categories')->where('id', $category_id)->get();
        $html = '<option value="">Select A Merchant</option>';
        foreach ($Category as $item){
            $html .= '<option value="'.$item->id.'">'.$item->area ?? '-'.'</option>';
        }
        return response()->json($html);
    }

    public function getMerchant(Request $request){
         $category_id = $request->merchant_id;
        $merchant = DB::table('merchants')->where('id',$category_id)->get();
        $html = '<option value="">Select A Brand name</option>';
        foreach ($merchant as $item){
            $html .= '<option value="'.$item->id.'">'.$item->company_name.'</option>';
        }
        return response()->json($html);

    }
    public function commission(Request $request){
        $category_id = $request->post('category_id');
        $offer = DB::table('offers')->where('category_id',$category_id)->get();
        $merchant = Merchant::all()->unique();
        $html = '<option value="">Select Merchant</option>';
        foreach ($offer as $item){
            foreach ($merchant as $merchants) {
                if ($merchants->id == $item->brand_name) {
                    $html .= '<option value="'.$merchants->id.'">'.$merchants->area.'</option>';
                }
            }
        }
        return response()->json($html);
    }
    public function getPermission(Request $request){


        $module_id = $request->post('module_id');
        $subModule = DB::table('sub_modules')->where('module_id', $module_id)->get();
        $html = '<option value="">Select A Sub Module</option>';
        foreach ($subModule as $item){
            $html .= '<option value="'.$item->id.'">'.$item->subModule_name.'</option>';
        }
        return response()->json($html);

    }
    public function search(Request $request){
        if ($request->ajax()) {
            $phone = $request->input('phone');
            $users = User::where('phone', 'LIKE', $phone . '%')->get() ?? [];


            // Pass the $users variable to the view
            return view('backend.merchant.physicallyApprove',compact('users'));
        }

    }
    public function searchMerchant(Request $request){
        $offer_id = $request->post('offer_id');
        $offer = DB::table('offers')->where('brand_name',$offer_id)->get();
        $html = '<option value="">Select Offer Title</option>';
        foreach ($offer as $item) {

            $html .= '<option value="'.$item->id.'">'.$item->offer_title.'</option>';
        }
        return response()->json($html);
    }

    // $merchant = DB::table('offers')->where('id', $offer_id)->get();
    public function user(Request $request){
        $merchant_id = $request->merchant_id;
        $offers = DB::table('offers')->where('merchant_id', $merchant_id)->get();
        $physicallyApprove = Physicallyapprove::all();
        $qrCode = QRCode::all();
        $html = '<option value="">Select An Offer Title</option>';

        foreach ($offers as $offer){
            foreach ($physicallyApprove as $item) {
                foreach($qrCode as $items){
                    if ($offer->id == $item->offer_id && $item->offer_id == $items->offer_id) {
                        $html .= '<option value="'.$offer->id.'">'.$offer->offer_title.'</option>';
                    }
                }
            }
        }
        return response()->json($html);
    }
    public function userName(Request $request){
        $offer = $request->offer_title;

// Fetch QR codes related to the offer
        $qrCodes = DB::table('qrcodes')->where('offer_id', $offer)->get();

        $html = '<option value="">Select A User Name</option>';

        foreach ($qrCodes as $qrCode) {
            // Retrieve the user associated with the current QR code
            $user = User::find($qrCode->user_id);

            if ($user) {
                $html .= '<option value="' . $user->id . '">' . $user->name . '</option>';
            }
        }

        return response()->json($html);

    }


    public function fixedAmount(Request $request){
        $offer_title = $request->offer_title_id;
        $qrCodes = DB::table('physicallyapproves')
            ->where('offer_id', $offer_title)
            ->get();
        $html = '<option value="">Select A Fixed Amount</option>';
        foreach ($qrCodes as $qrCode) {
            $html .= '<option value="'.$qrCode->id.'">'.$qrCode->fixed_amount.'</option>';
        }
        return response()->json($html);
    }


  public function percentageAmount(Request $request){
    $offer_title = $request->offer_title;
    $qrCodes = DB::table('physicallyapproves')
            ->where('offer_id', $offer_title)
            ->get();
    $html = '<option value="">Select A Fixed Amount</option>';
    foreach ($qrCodes as $qrCode) {
        $html .= '<option value="'.$qrCode->id.'">'.$qrCode->percentage_amount.'</option>';
    }
    return response()->json($html);
  }

  //offer
    public function userCommissionOffer(Request $request){
        $user_id = $request->user_name_1;
        $qrCode = DB::table('qrcodes')->where('user_id', $user_id)->get();
        $physicallyApprove = Physicallyapprove::all();
        $offer = Offer::all();
        $html = '<option value="">Select An Offer Title</option>';

        foreach ($qrCode as $qrCodes){
            foreach ($physicallyApprove as $item) {
                foreach($offer as $offers){

                if ($qrCodes->offer_id == $item->offer_id && $offers->id == $qrCodes->offer_id) {
                    $html .= '<option value="'.$offers->id.'">'.$offers->offer_title.'</option>';
                }
                }
            }
        }
        return response()->json($html);
    }
    public function getCategoryNew(Request $request){
        $merchantId = $request->merchant_id;
        $category = Category::where('merchant_id',$merchantId)->get();
        $html = '<option value="">Select A Category</option>';
        foreach($category as $categories){
            $html.= '<option value="'.$categories->id.'">'.$categories->category_name.'</option>';
        }
        return response()->json($html);
    }
//gotOffer
    public function gotOffer(Request $request){
        $merchant_id = $request->merchant_id;
        $offer = Offer::where('brand_name',$merchant_id)->get();
        $html = '<option value="">Select A Offer Title</option>';
        foreach ($offer as $items){
            $html.= '<option value="'.$items->id.'">'.$items->offer_title.'</option>';
        }
        return response()->json($html);
    }
    //userWise Offer_id
    public function getOffers(Request $request){
        $user_id = $request->user_id;
        $offer = QRCode::where('user_id',$user_id)->where('status','approved')->get();
        $html = '<option value="">Select A Offer Title</option>';
        foreach ($offer as $items){
            $html.= '<option value="'.$items->offer_id.'">'.$items->offer_title.'</option>';
        }
        return response()->json($html);
    }
    //offer wise area
    public function getAreas(Request $request){
        $offer_id = $request->offer_id;
        // $qrCode = QRCode::where('offer_id',$offer_id)->get();
        $offer = DB::table('offers')->where('id',$offer_id)->get();
        $merchant = Merchant::all();
        $html = '<option value="">Select A Offer Title</option>';
        foreach ($offer as $items){
            foreach($merchant as $merchants){
                if ($merchants->id == $items->brand_name) {
                    $html.= '<option value="'.$merchants->id.'">'.$merchants->areas->areaName.'</option>';
                }
            }
        }
        return response()->json($html);
    }
    public function getPlaceName(Request $request){
        $placeName_id = $request->placeName_id;
        $RateOffModdel = RateOfPrice::where('id',$placeName_id)->get();
        $html = '<option value="">Select A Place Rate</option>';
        foreach ($RateOffModdel as $value) {
            $html .= '<option value="'.$value->id.'">'.$value->ratePlace.'</option>';
        }
            return response()->json($html);
        }

        //getFixedAmount
     public function getFixedAmount(Request $request){
        $offer_id = $request->offer_id;
        $offer = Offer::where('id',$offer_id)->get();
        $html = '<option value="">Select Fixed Amount</option>';
        foreach($offer as $item){
                $html .= '<option value="'.$item->offer_amount.'">'.$item->offer_amount.'</option>';
        }
        return response()->json($html);
    }
    //getPercentageAmount
    public function getPercentageAmount(Request $request){
        $offer_id = $request->offer_id;
        $offer = Offer::where('id',$offer_id)->get();

        $html = '<option value="">Select Percentage Amount</option>';

        foreach($offer as $item){
                $html .= '<option value="'.$item->offer_percentage.'">'.$item->offer_percentage.'</option>';
        }
        return response()->json($html);
    }
    //getPrice
    public function getPrice(Request $request){
        $loation_id = $request->location_id;
        $ratePrice = RateOfPrice::where('id',$loation_id)->get();
        $html = '<option>Select Price</option>';
        foreach ($ratePrice as $ratePrices) {
            $html .= '<option value="'.$ratePrices->ratePlace.'">'.$ratePrices->ratePlace.'</option>';
        }
        return response()->json($html);
    }
    //getPlaceRate
    public function getPlaceRate(Request $request){
        $placeValue = $request->placeValue;
        $ratePrice = RateOfPrice::where('id',$placeValue)->get();
        $html = '<option>Select Price</option>';
        foreach ($ratePrice as $ratePrices) {
            $html .= '<option value="'.$ratePrices->ratePlace.'">'.$ratePrices->ratePlace.'</option>';
        }
        return response()->json($html);
    }

    //minimumPurchase
    public function minimumPurchase(Request $request){
        $offer_id = $request->offer_id;
        $offer = Offer::where('id', $offer_id)->first();

        if ($offer) {
            // return response()->json($offer);
            return response()->json($offer->minimum_perchase); // Replace 'minimum_purchase' with your actual column name
        }

        return response()->json(null);
    }

    //placeName
    public function placeName(Request $request){
        $placeName_id = $request->placeName_id;;
        $ratePrice = MerchantAdvertisement::where('id',$placeName_id)->get();

        $html = '<option>Select Price</option>';
        foreach ($ratePrice as $ratePrices) {
            $html .= '<option value="'.$ratePrices->ratePlace.'">'.$ratePrices->ratePlace.'</option>';
        }
        return response()->json($html);
    }
    public function findOffer(Request $request){
        $merchant_id = $request->merchant_id;
        $physicallyApprove = QRCode::where('merchant_id',$merchant_id)->where('status','pending')->get();

        $html = '<option>Select Offer</option>';

        foreach($physicallyApprove as $item){
                $html .= '<option value="'.$item->offer_id.'">'.$item->offer_title.'</option>';
        }
        return response()->json($html);
    }
    //offer to fixed
    public function offerToFixed(Request $request){
        $offer_id = $request->offer_id;;
        $fixedAmount = QRCode::where('offer_id',$offer_id)->where('status','pending')->get();

        $html = '<option>Select A fixed amount</option>';
        foreach ($fixedAmount as $fixedAmounts) {
            $html .= '<option value="'.$fixedAmounts->offer_amount.'">'.$fixedAmounts->offer_amount.'</option>';
        }
        return response()->json($html);
    }
    //offer to percentage
    public function offerToPercentage(Request $request){
        $offer_id = $request->offer_id;;
        $fixedAmount = QRCode::where('offer_id',$offer_id)->where('status','declined')->get();

        $html = '<option>Select A Percentage amount</option>';
        foreach ($fixedAmount as $fixedAmounts) {
            $html .= '<option value="'.$fixedAmounts->percentage_amount.'">'.$fixedAmounts->percentage_amount.'</option>';
        }
        return response()->json($html);
    }
     //offer to purchase
     public function offerToPurchaseAmount(Request $request){
        $offer_id = $request->offer_id;
        $fixedAmount = QRCode::where('offer_id',$offer_id)->where('status','pending')->get();
        $html = '<option>Select A Percentage amount</option>';
        foreach ($fixedAmount as $fixedAmounts) {
            $html .= '<option value="'.$fixedAmounts->purchase_amount.'">'.$fixedAmounts->purchase_amount.'</option>';
        }
        return response()->json($fixedAmount);
    }



}
