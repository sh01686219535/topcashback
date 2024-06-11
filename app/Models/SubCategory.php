<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function childcategory(){
        return $this->hasMany(ChildCategory::class);
    }
    public function offer(){
        return $this->hasMany(Offer::class,'subCategory_id','id');
    }
}
