<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Traits\HasPermissionsTrait;


class Admin extends Authenticatable
{

    use HasFactory,HasPermissionsTrait;
    protected $guarded = [];

    public function qrcodes(){
        return $this->hasMany(QRCode::class,'admin_id');
        }

    public function Permission(){
        return $this->hasMany(Permission::class);
    }

    public function financial(){
        return $this->hasMany(Financial::class);
    }


}
