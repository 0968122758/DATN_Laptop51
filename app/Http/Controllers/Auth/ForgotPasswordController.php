<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */

    // use SendsPasswordResetEmails;
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showForgetPasswordForm()
    {   
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('auth.forgetPassword');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {      
        $request->validate([
            'phone' => ['required', 'numeric', 'regex:/^(0)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/'],
        ],
        [
                'phone.required' => 'Yêu cầu nhập số điện thoại',
                'phone.numeric' => 'Số điện thoại phải là số',
                'phone.regex' => 'Số điện thoại phải thuộc đầu số Việt Nam',
        ]);
            $user_phone = User::where('phone',$request->phone)->get()->first;
            if($user_phone == NULL){
                return back();
                Toastr::error('Không tìm thấy số điện thoại, bạn có muốn tạo mới?', 'Thất bại');
            }
            $data['phone'] = $request->phone;
            $data['password'] = $request->password;
            $phoneSend['phone'] = '+84'. $request->phone;

            $pool = '0123456789';
            $code_verify = substr(str_shuffle(str_repeat($pool, 2)), 0, 6);
            /* Get credentials from .env */
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_number = getenv("TWILIO_NUMBER");
            $twilio = new Client($twilio_sid, $token);
            $twilio->messages->create(
                $phoneSend['phone'],
                array(
                    'from' => $twilio_number,
                    'body' => 'Ma xac minh cua ban la: '. $code_verify,
                )
                );
                // Tạo mã xác minh
            DB::table('code_verify')->insert([
                    'code_verify' => $code_verify,
                    'phone_number' => $request->phone,
                    'status' => 0,
                    'time_request' => 0,
                    'created_at' => Carbon::now(),
                ]);
    
            // dd($request->all());
        // if ($verification->valid) {
        //     $user = tap(User::where('phone', $data['phone']))->update(['isVerified' => true]);

        //   DB::table('password_resets')->insert([
        //       'phone' => $request->email,
        //       'token' => $token,
        //       'created_at' => Carbon::now()
        //     ]);
        session()->put('phone_number',$request->phone);
        Toastr::success('Gửi mã về số điện thoại', 'Thành công');
        return back()->with('message', 'Gửi mã thành công');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm(Request $request)
    {   
        if(session()->has('phone')){
            return view('auth.forgetPasswordLink');
        }elseif(Auth::check()){
            return redirect()->route('home');
        }
        return redirect()->route('login');
    }

    public function insertResetPasswordForm(Request $request)
    {   
        // dd($request->all());
        
        if(session()->has('phone')){
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'password.required' => 'Yêu cầu nhập mật khẩu',
                'password.string' => 'Mật khẩu phải là chuỗi ký tự',
                'password.min' => 'Mật khẩu không được nhỏ hơn 8 kí tự',
                'password.confirmed' => 'Mật khẩu không trùng vui lòng nhập lại',
            ]);
           $phone = session()->get('phone');
           $update_password = User::where('phone',$phone)->get()->first();
           $update_password->password = Hash::make($request->password);
           $update_password->save();
           session()->forget('phone');
        }else{
            return redirect()->route('login');
        }

        Toastr::success('Đổi mật khẩu thành công', 'Thành công');
        return redirect()->route('login');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {   
        
        session()->put('phone_number',$request->phone);
        $data = $request->validate([
            'code_verify' => ['required', 'numeric'],
            'phone' => ['required', 'numeric'],
        ],
        [
                'code_verify.required' => 'Yêu cầu nhập mã xác minh',
                'code_verify.numeric' => 'Mã xác minh phải là số',
                'phone.required' => 'Yêu cầu nhập số điện thoại',
                'phone.numeric' => 'Số điện thoại phải là số',
        ]);
        $user_phone = User::where('phone',$request->phone)->get()->first();
        if($user_phone == NULL){
            return back();
            Toastr::error('Không tìm thấy số điện thoại', 'Thất bại');
        }
        $code_verify = DB::table('code_verify')->where('phone_number',$request->phone)->orderBy('created_at','DESC')->first();
        $phoneSend['phone'] = '+84'. session()->get('phone_number');
        // dd($request->phone);
        if ($request->code_verify == $code_verify->code_verify && $request->phone == $code_verify->phone_number && $code_verify->status == 0) {
            $user = tap(User::where('phone', $request->phone))
            ->update([
                'isVerified' => true,
            ]);
            $update_code_verify = DB::table('code_verify')
            ->where('phone_number', $request->phone)
            ->orderBy('created_at','DESC')
            ->limit(1)
            ->update(['status' => 1]);
            session()->forget('phone_number');
            session()->put(['phone' => $request->phone]);
            Toastr::success('Xác minh số điện thoại thành công, vui lòng đổi mật khẩu', 'Thành công');
            return view('auth.forgetPasswordLink');
        }
        
        elseif($request->phone == $code_verify->phone_number){
            $actual_end_at = Carbon::parse(Carbon::now());
            $actual_start_at   = Carbon::parse($code_verify->created_at);
            $mins = $actual_end_at->diffInMinutes($actual_start_at, true);
            if($code_verify->time_request >= 10 || $mins >= 20 || $code_verify->status == 1){
                $update_code_verify = DB::table('code_verify')
                ->where('phone_number', $request->phone)
                ->orderBy('created_at','DESC')
                ->limit(1)
                ->update(['status' => 1]);
                Toastr::error('Mã xác minh đã quá hạn, vui lòng gửi lại mã', 'Thất bại');
                return back(); 
            }
            $update_code_verify = DB::table('code_verify')
              ->where('phone_number', $request->phone)
              ->orderBy('created_at','DESC')
              ->limit(1)
              ->update(['time_request' => $code_verify->time_request + 1]);
            Toastr::error('Mã xác minh không đúng 123132131', 'Thất bại');
            return back();
        }
        Toastr::error('Mã xác minh không đúng', 'Thất bại');
        return back()->with(['phone' => $data['phone']]);
    }
}
