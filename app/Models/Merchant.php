<?php

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Merchant extends  Authenticatable   implements JWTSubject
{
    use HasFactory, HasFactory, Notifiable;


    protected $guarded = [];
    public function getAuthIdentifier()
    {
        return $this->merchant_email; // Replace with the field that uniquely identifies merchants
    }

    public function getAuthPassword()
    {
        return $this->password; // Replace with the field that stores the hashed password
    }

    public function offer(){
        return $this->hasMany(Offer::class);
    }
    public function payouts(){
        return $this->hasMany(Payout::class);
    }
    public function financial(){
        return $this->hasMany(Financial::class);
    }
    public function category(){
        return $this->hasMany(Category::class,'merchant_id');
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function RateOff(){
        return $this->HasOne(RateOfPrice::class);
    }
    public function areas(){
        return $this->belongsTo(Area::class,'area','id');
    }
    public function physicallyApprove(){
        return $this->HasOne(Physicallyapprove::class);
    }

}
