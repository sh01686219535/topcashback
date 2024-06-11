<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subCategory(){
        return $this->hasMany(SubCategory::class);
    }
    public function offer(){
        return $this->hasMany(Offer::class);
    }
    public function merchant(){
        return $this->belongsTo(Merchant::class,'merchant_id');
    }
    public static function get_merchant_details($category_id)
    {
        $result = DB::table('categories')
        ->leftJoin('merchants', 'categories.merchant_name', '=', 'merchants.id')
        ->select('merchants.merchant_name AS name')
        ->where('categories.id', $category_id)
        ->first();


    if ($result) {
        // A matching record was found, return the result.
        return $result;
    } else {
        // No matching record was found, return an appropriate response.
        return response()->json(['message' => 'merchant name not found'], 404);
    }
}
}
