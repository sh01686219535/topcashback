<?php

namespace App\Models;

use App\Models\Footermenu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FooterDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function footerDetail(){
        $this->belongsTo(Footermenu::class);
    }
}
