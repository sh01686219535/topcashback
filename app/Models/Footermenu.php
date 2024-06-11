<?php

namespace App\Models;

use App\Models\FooterDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Footermenu extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function footerDetail(){
        $this->hasMany(FooterDetail::class);
    }
}
