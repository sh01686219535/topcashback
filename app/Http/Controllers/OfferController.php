<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Advertisement;
use App\Models\Offer;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\CashBackOfferQrCode;
use App\Models\Merchant;
use App\Models\MerchantAdvertisement;
use App\Models\RateOfPrice;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;


class OfferController extends Controller
{
    public function offer()
    {
        // if(auth('admin')->user()->can('view-offer')){
            // $admin = Auth::guard('admin')->user()->merchant_id == 0 || Auth::guard('admin')->user()->merchant_id =='NULL';
            // $offer = Offer::select('id')->get();
            // if ($admin) {
            //     $offer = Offer::latest()->get();
            //     return view('backend.offer.offer', compact('offer'));
            // }elseif (auth('admin')->user()->id == $offer) {
            //     $offer = Offer::latest()->get();
            //     return view('backend.offer.offer', compact('offer'));
            // }
            $admin = Auth::guard('admin')->user()->merchant_id == 0 || Auth::guard('admin')->user()->merchant_id == null;

            if ($admin) {
                $offer = Offer::latest()->get();
                return view('backend.offer.offer', compact('offer'));
            } else {
                // $offer = Offer::latest()->all();
                $admin = Auth::guard('admin')->user();

                if ($admin->merchant_id !== 0 && $admin->merchant_id !== null) {
                    $id = $admin->merchant_id;
                    $offers = Offer::where('merchant_id', $id)->pluck('merchant_id');
                //    dd($offers->contains($id));
                    if ($offers->contains($id)) {
                        $offer = Offer::where('merchant_id', $id)->get();
                        return view('backend.offer.offer', compact('offer'));
                    }
                } else {
                    dd("Merchant ID is 0 or null.");
                }
            }

// Handle cases where the admin user is not an admin with merchant_id 0 or doesn't match any offer.

    // }
    // abort(403, 'Unauthorized action.');
    }
   // add product
   public function addOffer()
   {
       if(auth('admin')->user()->can('create-offer')){
       $advertisement = MerchantAdvertisement::where('merchant_id',Auth::guard('admin')->user()->merchant_id)->first() ?? 0;
       $category = Category::latest()->get();
       $subCategory = SubCategory::latest()->get();
       $childCategory = ChildCategory::latest()->get();
       $offer = Offer::with('merchant')->latest()->get();
       $merchant = Merchant::all();
       $RateOff = RateOfPrice::latest()->get();
       return view('backend.offer.add-offer', compact('merchant','advertisement','RateOff','category', 'subCategory', 'childCategory', 'offer','merchant'));
   }
   abort(403, 'Unauthorized action.');
   }
    // store product
    public function saveOffer(Request $request)
    {
        $validatedData=$request->validate([
            'category_id' => 'required',
            'subCategory_id' => 'required',
            'offer_title' => 'required',
            // 'offer_amount' => 'required',
            // 'offer_percentage' => 'required',
            'offer_description' => 'required',
            'offer_image' => 'required|mimes:jpeg,jpg,png,gif',
            'banner_image' => 'required|mimes:jpeg,jpg,png,gif',
            // 'affiliate_link' => 'required',
            // 'status' => 'required|in:true,false',
            'brand_name' => 'required',
            // 'placeName' => 'required',
            // 'placeRate' => 'required',
            'merchant_id' => 'required',
            'minimum_perchase'=>'required'

        ]);
        $offer = new Offer();
        $offer->category_id = $request->category_id;
        $offer->subCategory_id = $request->subCategory_id;
        $offer->offer_title = $request->offer_title;
        $offer->offer_amount = $request->offer_amount;
        $offer->offer_percentage = $request->offer_percentage;
        $offer->offer_description = $request->offer_description;
        $offer->minimum_perchase = $request->minimum_perchase;
        $offer->merchant_id = $request->merchant_id;
        $offer->brand_name = $request->brand_name;
        $offer->placeName = $request->placeName;
        $offer->placeRate = $request->placeRate;
        // $offer->status = $request->status;
        if ($request->file('offer_image')) {
            $offer->offer_image = $this->makeImage($request);
        }
        if ($request->file('banner_image')) {
            $offer->banner_image = $this->makeBanner($request);
        }
        // dd($offer);
        $offer->save();
        return redirect('/offer')->with('message', 'Offer Add Successfully');
    }

    // image
    private function makeImage($request)
    {
        $image = $request->file('offer_image');
        $imageName = rand() . '.' . $image->getClientOriginalExtension();
        $directory = public_path('admin/assets/offer-image/');
        $path = 'admin/assets/offer-image/';
        $imageUrl = $path . $imageName;
        $image->move($directory, $imageName);
        return $imageUrl;
    }
    private function makeBanner($request)
    {
        $image = $request->file('banner_image');
        $imageName = rand() . '.' . $image->getClientOriginalExtension();
        $directory = public_path('admin/assets/offer-banner/');
        $path = 'admin/assets/offer-banner/';
        $imageUrl = $path . $imageName;
        $image->move($directory, $imageName);
        return $imageUrl;
    }

    public function deleteOffer($id)
    {
        if(auth('admin')->user()->can('delete-offer')){
        $offer = Offer::findOrFail($id); // Find the offer

        $offerImage = $offer->offer_image; // Get the offer_image path

        $deleted = $offer->delete(); // Delete the offer and get the result (true or false)

        if ($deleted && $offerImage) {
            // If the offer was successfully deleted and offer_image exists, delete the file
            if (file_exists(public_path($offerImage))) {
                unlink(public_path($offerImage));
            }
        }

        return redirect()->back();
    }
    abort(403, 'Unauthorized action.');
    }
    // edit product
    public function editOffer($id)
    {
        if(auth('admin')->user()->can('edit-offer')){
        $Offer = Offer::find($id);

        $advertisement = MerchantAdvertisement::all();
        //  dd($advertisement);
        $category = Category::latest()->get();
        $subCategory = SubCategory::latest()->get();
        $merchant = Merchant::all();
        // $user = Auth::guard('admin')->user();
        // if ($user) {
        //     $merchant_id = $user->merchant_id;
        //     $merchant= Merchant::where('id',$merchant_id)->get();
        // }
        // }else{
        // $merchant = Merchant::latest()->get();
        // }


        $RateOff = RateOfPrice::latest()->get();
        return view('backend.offer.edit-offer', compact('advertisement','RateOff','merchant','category', 'subCategory', 'Offer'));
    }
    abort(403, 'Unauthorized action.');
    }
    // update product
    public function updateOffer(Request $request)
    {
        // return $request;

        $offer = Offer::find($request->offer_id);
        $request->validate([
            'category_id' => 'required',
            'subCategory_id' => 'required',
            'offer_title' => 'required',
            // 'offer_amount' => 'required',
            'minimum_perchase' => 'required',
            'offer_description' => 'required',

            'brand_name' => 'required',
            'merchant_id' => 'required',
        ]);
        $offer->category_id = $request->category_id ;
        $offer->subCategory_id = $request->subCategory_id;
        $offer->offer_title = $request->offer_title;
        $offer->offer_amount = $request->offer_amount;
        $offer->offer_percentage = $request->offer_percentage;
        $offer->offer_description = $request->offer_description;
        $offer->minimum_perchase = $request->minimum_perchase;
        $offer->merchant_id = $request->merchant_id;
        $offer->brand_name = $request->brand_name;
        $offer->placeName = $request->placeName;
        $offer->affiliate_url = $request->affiliate_url;
        $offer->placeRate = $request->placeRate;
        $offer->status = 'true';
        if ($request->file('offer_image')) {
            $offer->offer_image = $this->makeImage($request);
        }
        if ($request->file('banner_image')) {
            $offer->banner_image = $this->makeBanner($request);
        }
        $offer->save();
        return redirect('/offer')->with('message', 'Offer Update Successfully');
    }
     //merchantOffer
     public function merchantOffer()
     {
         if(auth('admin')->user()->can('view merchant offer')){
         $advertisement = MerchantAdvertisement::where('merchant_id',Auth::guard('admin')->user()->merchant_id)->where('status','pending')->first() ?? 0;
         $category = Category::latest()->get();
         $subCategory = SubCategory::latest()->get();
         $offer = Offer::with('merchant')->latest()->get();
      //    $merchant = Merchant::latest()->get();
          $user = Auth::guard('admin')->user();
          if ($user) {
              $merchant_id = $user->merchant_id;
              $merchant= Merchant::where('id',$merchant_id)->get();
          }
         $advertisements = MerchantAdvertisement::where('merchant_id',$user->merchant_id)->where('status','pending')->get();

         return view('backend.offer.add-merchant-offer', compact('merchant','advertisement','advertisements','category', 'subCategory', 'offer','merchant'));
     }
     abort(403, 'Unauthorized action.');
     }
     ////merchant save offer
     public function saveMerchantOffer(Request $request){

        $validatedData=$request->validate([
            'category_id' => 'required',
            'subCategory_id' => 'required',
            'offer_title' => 'required',
            // 'offer_amount' => 'required',
            // 'offer_percentage' => 'required',
            'offer_description' => 'required',
            'offer_image' => 'required|mimes:jpeg,jpg,png,gif',
            'banner_image' => 'required|mimes:jpeg,jpg,png,gif',
            // 'affiliate_link' => 'required',
            // 'status' => 'required|in:true,false',
            'brand_name' => 'required',
            // 'placeName' => 'required',
            // 'placeRate' => 'required',
            'merchant_id' => 'required',

            // 'minimum_perchase'=>'required'

        ]);
        $offer = new Offer();
        $offer->category_id = $request->category_id;
        $offer->subCategory_id = $request->subCategory_id;
        $offer->offer_title = $request->offer_title;
        // $offer->offer_amount = $request->offer_amount;
        // $offer->offer_percentage = $request->offer_percentage;
        $offer->offer_description = $request->offer_description;
        // $offer->minimum_perchase = $request->minimum_perchase;
        $offer->merchant_id = $request->merchant_id;
        $offer->brand_name = $request->brand_name;
        $offer->placeName = $request->placeName;
        $offer->placeRate = $request->placeRate;
        $offer->affiliate_url = $request->affiliate_url;
        // $offer->status = 'false';
        if ($request->file('offer_image')) {
            $offer->offer_image = $this->makeImage($request);
        }
        if ($request->file('banner_image')) {
            $offer->banner_image = $this->makeBanner($request);
        }
        // dd($offer);
        $offer->save();
        $advertisement = MerchantAdvertisement::where('merchant_id',Auth::guard('admin')->user()->merchant_id)->where('status','pending')->first() ?? 0;
        if($advertisement){
            $advertiseMerchant = MerchantAdvertisement::find($request->placeName);

        $advertiseMerchant->update([
            'status' => 'approved'
        ]);
        }

        return back()->with('message', 'Offer Add Successfully');
     }

     ///approve offer
     public function approveOffer(){
         if(auth('admin')->user()->can('view approve offer')){
        $offer= Offer::where('status','false')->get();
        return view('backend.offer.approveOffer',compact('offer'));
         }
        abort(403, 'Unauthorized action.');
     }
     //approveEditOffer
     public function approveEditOffer($id){
        if(auth('admin')->user()->can('edit approve offer')){
            // $advertisements = MerchantAdvertisement::where('merchant_id',Auth::guard('admin')->user()->merchant_id)->where('status','approved')->first() ?? 0;

            $Offer = Offer::find($id);
            $advertisements = Offer::where('placeName',$Offer->placeName)->first();
            $advertisement = MerchantAdvertisement::all();

            $category = Category::latest()->get();
            $subCategory = SubCategory::latest()->get();
            $merchant = Merchant::all();
            $RateOff = RateOfPrice::latest()->get();
            return view('backend.offer.approve-edit-offer', compact('advertisements','advertisement','RateOff','merchant','category', 'subCategory', 'Offer'));
        }
        abort(403, 'Unauthorized action.');
     }

}
