<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantAdvertisement extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function merchant(){
        return $this->belongsTo(Merchant::class,'merchant_id','id');
    }
    public function rateOffPrice(){
        return $this->belongsTo(RateOfPrice::class,'placeName','id');
    }
    public function offer(){
        return $this->belongsTo(Offer::class);
    }

}
