<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class LogActivity extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function storeLogActivity($activity, $role = null) {
        if (self::all()->count() > 0) {
            if (self::orderBy('created_at', 'desc')->first()->role != 'disabled') {
                $log = [
                    'activity' => $activity,
                    'role' => 'guest',
                    'url' => Request::fullUrl(),
                    'method' => Request::method(),
                    'ip' => Request::ip(),
                    'agent' => Request::header('user-agent'),                
                ];
                if (Auth::check()) {
                    if ($role == 'admin') {
                        $log['user_id'] = Auth::user()->id;
                        $log['role'] = 'admin';
                    }
                    if (Customer::where('email', Auth::user()->email)->exists()) {
                        $log['user_id'] = Auth::user()->id;
                        $log['role'] = 'customer';
                    }
                }
                return self::create($log);
            }
        }
    }

    public static function getLogActivityByCustomerId($customer_id) {
        return self::where('role', 'customer')->where('user_id', $customer_id)->get();
    }

    public static function getLogActivityByAdminId($admin_id) {
        return self::where('role', 'admin')->where('user_id', $admin_id)->get();
    }
}
