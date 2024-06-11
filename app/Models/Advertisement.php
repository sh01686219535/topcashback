<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function merchant(){
        return $this->belongsTo(Merchant::class,'merchant_id','id');
    }
    public function rateOffModel(){
        return $this->belongsTo(RateOfPrice::class,'addLocation','id');
    }

}
