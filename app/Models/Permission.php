<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected  $fillable = ['permission_name', 'slug','module_id','sub_module_id', 'created_by', 'updated_by'];
    public function roles() {

        return $this->belongsToMany(Role::class,'roles_permissions');

    }
    public function admin() {

        return $this->belongsToMany(Admin::class,'admins_permissions');

    }

    public function merchant() {

        return $this->belongsToMany(Merchant::class,'users_permissions');

    }
    public function module(){
        return $this->belongsTo(Module::class,'module_id');
    }
    public function subModule(){
        return $this->belongsTo(SubModule::class,'sub_module_id');
    }
}
