<?php 

use Illuminate\Support\Facades\Auth;
use App\Models\User;

if (!function_exists('is_direktur')) {
    function is_direktur() {
            if (!Auth::check()) return false;
            $user = Auth::user();
            if($user->role == 'direktur'){
                return true;
            }else{
                return false;
            }
    }
}

if (!function_exists('is_staff')) {
    function is_staff() {
            if (!Auth::check()) return false;
            $user = Auth::user();
            if($user->role == 'staff'){
                return true;
            }else{
                return false;
            }
    }
}


if (!function_exists('is_finance')) {
    function is_finance() {
            if (!Auth::check()) return false;
            $user = Auth::user();
            if($user->role == 'finance'){
                return true;
            }else{
                return false;
            }
    }
}