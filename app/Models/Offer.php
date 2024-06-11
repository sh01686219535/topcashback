<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Offer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class,'subCategory_id');
    }
    public function merchant(){
        return $this->belongsTo(Merchant::class,'brand_id');
    }
    public function banner(){
        return $this->belongsTo(Banner::class,'banner_id');
    }

    public function user(){
        return $this->belongsTo(Admin::class,'offer_id');
    }
    public function payouts(){
        return $this->hasMany(Payout::class);
    }
    public static function get_merchant_details($offer_id)
    {
        return DB::table('offers')
            ->leftJoin('merchants', 'merchants.id', '=', 'offers.merchant_id')
            ->select('merchants.merchant_name', 'merchants.id')
            ->where('offers.id', $offer_id)
            ->get();
    }
    public function areas(){
        return $this->belongsTo(Area::class);
    }
    //advertisement
    public function advertisement(){
        return $this->belongsTo(MerchantAdvertisement::class,'placeName');
    }

}
