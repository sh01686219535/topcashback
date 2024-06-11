<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Physicallyapprove extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function offer()
    {
        return $this->belongsTo(Offer::class,'offer_id','id');
    }
    public function users(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
