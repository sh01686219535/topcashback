<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Advertisement;
use App\Models\Area;
use App\Models\Category;
use App\Models\MerchantAdvertisement;
use App\Models\RateOfPrice;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class MerchantController extends Controller
{
    //merchant
    public function merchant()
    {
        if (auth('admin')->user()->can('view-merchant')) {
            $merchant = Merchant::latest()->get();
            return view('backend.merchant.merchant', compact('merchant'));
        }
        abort(403, 'Unauthorized action.');
    }
    // edit merchant
    public function editMerchant($id)
    {
        if (auth('admin')->user()->can('edit-merchant')) {
            $merchant = Merchant::find($id);
            $offer = Offer::all();
            $area = Area::all();
            return view('backend.merchant.edit-merchant', compact('area','merchant', 'offer'));
        }
        abort(403, 'Unauthorized action.');
    }
    // update merchant
    public function updateMerchant(Request $request)
    {   $merchant = Merchant::find($request->merchant_id);

        $request->validate([
            'merchant_name' => 'required',
            'merchant_number' => 'required',
            // 'merchant_email' => 'required',
            'company_name' => 'required',
            // 'merchant_password' => 'required',
            'postcode' => 'required',
            'area' => 'required',
        ]);
        // $imageExtension = request()->file('merchant_image')->extension();
        // $imageName = "photo".uniqid()."_".time().".".$imageExtension;

        // request()->file('merchant_image')->move('images',$imageName);

        $merchant->update([
            'merchant_name' => \request('merchant_name'),
            'merchant_number' => \request('merchant_number'),
            'merchant_email' => \request('merchant_email'),
            'area' => \request('area'),
            'company_name' => \request('company_name'),
            'merchant_image' => $request->hasFile('merchant_image') ? $this->makeImage($request) : \request('merchant_image'),

            'merchant_password' => bcrypt(request('merchant_password')),
            // 'merchant_confirm' => bcrypt(request('merchant_confirm')),
            'address' => request('address'),
            'postcode' => request('postcode'),
            'merchant_secondary_number' => request('merchant_secondary_number'),
            'city' => request('city'),
        ]);

        return redirect('/merchant')->with('message', 'Merchant Update Successfully');
    }
    // image
    private function makeImage($request){
        $image = $request->file('merchant_image');
        $imageName = uniqid().'.'.$image->getClientOriginalExtension();
        $directory = public_path('admin/assets/merchant-image/');
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
    // delete merchant
    public function deleteMerchant($id)
    {
        if (auth('admin')->user()->can('delete-merchant')) {
           $merchant= Merchant::find($id);
           if ($merchant) {

            if ($merchant->merchant_image) {
                $imagePath = public_path('images/' . $merchant->merchant_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete the merchant record from the database
            $merchant->delete();

            return back()->with('message', 'Merchant Delete Successfully');
        } else {
            // Handle the case where the merchant with the given ID is not found
        }
        }
        abort(403, 'Unauthorized action.');
    }
    // add merchant
    public function addMerchant()
    {

        if(auth('admin')->user()->can('create-merchant')){

        $area = Area::all();
        $offer = Offer::all();

        return view('backend.merchant.add-merchant', compact('offer','area'));
        }
        abort(403, 'Unauthorized action.');
    }
    // save merchant
    public function saveMerchant(Request $request)
    {
        $request->validate([
            'merchant_name' => 'required',
            'merchant_number' => 'required',
            'merchant_email' => 'required|unique:merchants',
            'company_name' => 'required',
            'merchant_password' => 'required',
            'merchant_confirm' => 'required|same:merchant_password',
            'postcode' => 'required',
            'area' => 'required',
        ]);
        // $imageExtension = request()->file('merchant_image')->extension();
        // $imageName = "photo".uniqid()."_".time().".".$imageExtension;

        // request()->file('merchant_image')->move('images',$imageName);

        $merchant = Merchant::create([
            'merchant_name' => \request('merchant_name'),
            'merchant_number' => \request('merchant_number'),
            'merchant_email' => \request('merchant_email'),
            'area' => \request('area'),
            'company_name' => \request('company_name'),
            // 'merchant_image' => $this->makeImage($request),
            'merchant_image' => $request->hasFile('merchant_image') ? $this->makeImage($request) : \request('merchant_image'),

            'merchant_password' => bcrypt(request('merchant_password')),
            // 'merchant_confirm' => bcrypt(request('merchant_confirm')),
            'address' => request('address'),
            'postcode' => request('postcode'),
            'merchant_secondary_number' => request('merchant_secondary_number'),
            'city' => request('city'),
            'latitude' => \request('latitude'),
            'longitude' => \request('longitude'),
        ]);
        $mid = Merchant::all()->last()->id;
        $admin = Admin::create([
            'name' => $request->merchant_name,
            'email' => $request->merchant_email,
            'password' => bcrypt($request->merchant_password),
            'merchant_id' => $mid,
        ]);
        $admin->roles()->attach('3');
        return to_route('merchant', compact('merchant'))->with('message', 'Merchant Created Successfully');
    }


}
