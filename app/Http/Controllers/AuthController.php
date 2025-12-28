<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        session()->put('otp_expires_at',$otp->expired_at);

        //TODO
        //Send SMS
        
        flash()->flash('success',"کد تائید برای شماره موبایل $user->mobile ارسال گردید.");
        return to_route('auth.otp');

    }

    public function verifyOtp(Request $request)
    {
        $mobile = session()->get('mobile');
        $request->validate(['otp' => 'required|numeric']);

        $user = User::where('mobile',$mobile)->first();

        if(!$user){
            flash()->flash('error','کاربر یافت نشد');
            return to_route('auth.login');
        }

        $otpRecord = Otp::where('otp',$request->otp)
                        ->where('user_id',$user->id)
                        ->where('expired_at','>',now())
                        ->first();

        if(!$otpRecord){
            flash()->flash('error','کد تائید اشتباه است و یا منقضی شده است.');
            return to_route('auth.otp');
        }

        Auth::login($user);
        //TODO
        //Insert to Log table
        // Log::event();
        if($user->role == "admin"){
            return to_route('admin.index');
        }elseif($user->role == "customer"){
            return "Profile User";
        }

        $otpRecord->delete();
        session()->forget('mobile');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return to_route('auth.login');
    }

    public function resendOtp()
    {
        $mobile = session()->get('mobile');
        session()->put('otp_expires_at',now()->addMinutes(3));

        $user = User::where('mobile',$mobile)->first();
        if(! $user){
            $user = User::create([
                'name' => $mobile,
                'mobile' => $mobile
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

        //TODO
        //Send SMS
        
        flash()->flash('success',"کد تائید مجددا برای شماره موبایل $user->mobile ارسال گردید.");
        return to_route('auth.otp');

    }


}
