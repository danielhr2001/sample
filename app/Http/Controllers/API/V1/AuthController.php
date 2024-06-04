<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Models\OTP;
use App\Models\User;
use App\Services\SMS;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;
use App\Http\Requests\API\V1\Auth\PhoneCheckerRequest;
use App\Http\Requests\API\V1\Auth\LoginByPasswordRequest;
use App\Http\Requests\API\V1\Auth\OTPVerificationRequest;

class AuthController extends Controller
{
    public function phoneChecker(PhoneCheckerRequest $request)
    {
        $inputs = $request->validated();
        try {
            $user = User::create(['phone_number' => $inputs['phone_number']]);
        } catch (Exception $e) {
            $user = User::where('phone_number', $inputs['phone_number'])->first();
        }
        //* send OTP
        //! موقت
        $OTP_code = OTP::where('device_ip', $request->getClientIp())->latest('created_at')->first();
        if (isset($OTP_code)) {
            $OTP_code_expire_at = Carbon::createFromFormat('Y-m-d H:i:s', $OTP_code->expire_at);
            $now = Carbon::createFromFormat('Y-m-d H:i:s', now());
            if ($OTP_code_expire_at->greaterThan($now)) {
                return response()->json(["message" => "برای ارسال مجدد کد باید 2 دقیقه صبر کنید"], 400);
            }
        }
        $OTP_code = OTP::create([
            'code' => rand(100000, 999999),
            'user_id' => $user->id,
            'device_ip' =>  $request->getClientIp(),
            'expire_at' =>  Carbon::parse(now())
                ->addSeconds(120),
        ]);

        // $result_message = SMS::smsSenderToSingleUser($user, "کد ورود $OTP_code->code");
        return response()->json(["OTPCode" => $OTP_code->code,]);
        // return response()->json(["message" => $result_message]);
    }

    public function OTPVerification(OTPVerificationRequest $request)
    {
        $inputs = $request->validated();
        $user = User::where('phone_number', $inputs['phone_number'])->first();
        if (!isset($user)) {
            return response()->json(["message" => "اطلاعات ورودی تطابق ندارد"], 400);
        }
        if($user->latestOTP){
            $OTP_code_expire_at = Carbon::createFromFormat('Y-m-d H:i:s', $user->latestOTP->expire_at);
            $now = Carbon::createFromFormat('Y-m-d H:i:s', now());
            if ($user->latestOTP->code != $inputs['OTP_code']) {
                return response()->json(["message" => "کد نادرست است"], 400);
            } else
            if ($now->greaterThan($OTP_code_expire_at)) {
                return response()->json(["message" => "کد منقضی شده است"], 400);
            }
        }
        if (!$user->activation_status) {
            $user->activation_status = 1;
            $user->save();
        }
        $users = User::where('activation_status', 0)->where('phone_number', $inputs['phone_number'])->get();
        foreach ($users as $old_user) {
            $old_user->delete();
        }
        $token = $user->createToken('something')->plainTextToken;
        unset($user->latestOTP);
        return response()->json(["token" => $token, "message" => "تایید موفقیت آمیز بود", "user" => $user->makeHidden(['is_admin', 'is_ban'])]);
    }

    public function logout()
    {
        try {
            auth('sanctum')->user()->currentAccessToken()->delete();
            return response()->json(["message" => "خروج موفقیت آمیز بود"]);
        } catch (Throwable $e) {
            return response()->json(["message" => "درحال حاضر در حساب کاربری نیستید."], 422);
        }
    }

    public function loginByPassword(LoginByPasswordRequest $request)
    {
        $inputs = $request->validated();
        try {
            $user = User::where('phone_number', $inputs['phone_number'])->orWhere('email',$inputs['email'])->where('activation_status', 1)->firstOrFail();
        } catch (Throwable $e) {
            return response()->json(["message" => "اطلاعات اشتباه است"], 404);
        }
        if (!Hash::check($inputs['password'], $user->password)) {
            return response()->json(["message" => "اطلاعات اشتباه است"], 404);
        }
        $token = $user->createToken('something')->plainTextToken;
        return response()->json(["token" => $token, "user" => $user]);
    }

    public function userInfo()
    {
        try {
            $user = auth('sanctum')->user();
            return response()->json($user->makeHidden(['is_admin', 'is_ban']));
        } catch (Throwable $e) {
            return response()->json(["message" => "درحال حاضر در حساب کاربری نیستید."], 422);
        }
    }
}
