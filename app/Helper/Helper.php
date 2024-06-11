<?php
namespace App\Helper;

use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Currency;
use App\Models\EmployeeSalary;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Schedule;
use App\Models\StaticOption;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// Define the set_static_option function
function set_static_option($key, $value)
{
    if (!StaticOption::where('option_name', $key)->first()) {
        StaticOption::create([
            'option_name' => $key,
            'option_value' => $value
        ]);
        return true;
    }
    return false;
}

// Define the get_static_option function
function get_static_option($key)
{
    if (StaticOption::where('option_name', $key)->first()) {
        $return_val = StaticOption::where('option_name', $key)->first();
        return $return_val->option_value;
    }
    return null;
}

// Define the update_static_option function
function update_static_option($key, $value)
{
    if (!StaticOption::where('option_name', $key)->first()) {
        StaticOption::create([
            'option_name' => $key,
            'option_value' => $value
        ]);
        return true;
    } else {
        StaticOption::where('option_name', $key)->update([
            'option_name' => $key,
            'option_value' => $value
        ]);
        return true;
    }
    return false;
}

// Define the file_uploader function
function file_uploader($folder_path, $file, $new_file_name = null)
{
    // ...
}

class Helper{
    //currency load
    public static function currency_load(){
        if(session()->has('system_default_currency_info')==false){
            session()->put('system_default_currency_info',Currency::find(1));
        }
    }
}
