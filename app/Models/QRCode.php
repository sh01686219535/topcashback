<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class QRCode extends Model
{
    use HasFactory;
    protected $table = 'qrcodes';
    // protected $guarded = [];
    protected $guarded= [];

    public function admins()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function offer(){
        return $this->belongsTo(Offer::class);
    }
    public function merchant(){
        return $this->belongsTo(Merchant::class,'merchant_id','id');
    }
    public static function get_user_details($offer)
    {
        $result = DB::table('qrcodes')
        ->leftJoin('users', 'users.id', '=', 'qrcodes.user_id')
        ->select('users.name AS user_name', 'users.id AS user_id') // Rename the fields
        ->where('qrcodes.user_id', $offer)
        ->first();

    if ($result) {
        // A matching record was found, return the result.
        return $result;
    } else {
        // No matching record was found, return an appropriate response.
        return response()->json(['message' => 'QR Code not found'], 404);
    }
}
}

