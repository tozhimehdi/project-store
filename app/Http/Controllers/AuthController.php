<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function otp()
    {
        return view('auth.otp');
    }
    
    public function requestOtp(Request $request)
    {
        $request->validate(['mobile' => 'required|numeric|regex:/^09[0-9]{9}$/']);

        $user = User::where('mobile',$request['mobile'])->first();
        if(! $user){
            $user = User::create([
                'name' => $request->mobile,
                'mobile' => $request->mobile
            ]);
        }

        $lastOtp = Otp::where('user_id',$user->id)->orderBy('created_at','desc')->first();

        if($lastOtp && $lastOtp->expired_at > now()){
            flash()->flash('error','باید 3 دقیقه از درخواست ارسال کد تائیدیه بگذرد.',['timeout'=>10000],'خطا');
            return redirect()->back();
        }

        $otpCode = rand(1000,9999);
        $otp = Otp::create([
            'user_id' => $user->id,
            'otp' => $otpCode,
            'expired_at' => now()->addMinutes(3)
        ]);

        session()->put('mobile',$request->mobile);
        session()->put('otpExpiredAt',$otp->expired_at);

        //TODO
        //Send SMS
        
        flash()->flash('success',"کد تائید برای شماره موبایل $user->mobile ارسال گردید.");
        return to_route('auth.otp');

    }

    public function verifyOtp(Request $request)
    {

    }


}
