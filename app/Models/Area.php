<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function merchant(){
        return $this->hasOne(Merchant::class);
    }
    // public function area(){
    //     return $this->belongsTo(Area::class);
    // }
    public function rateOfPlace(){
        return $this->hasOne(RateOfPrice::class);
    }
}
