<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateOfPrice extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function merchant(){
        return $this->belongsTo(Merchant::class);
    }
    public function area(){
        return $this->belongsTo(Area::class);
    }
}
