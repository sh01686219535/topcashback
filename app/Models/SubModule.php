<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SubModule extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function module(){
        return $this->belongsTo(Module::class);
    }
    public function permission(){
        return $this->hasMany(Permission::class);
    }
    // public static function get_module_details($module_id)
    // {
    //     return DB::table('sub_modules')
    //         ->leftJoin('modules', 'modules.id', '=', 'sub_modules.sub_modules')
    //         ->select('sub_modules.subModule_name', 'sub_modules.id')
    //         ->where('modules.id', $module_id)
    //         ->get();
    // }
}
