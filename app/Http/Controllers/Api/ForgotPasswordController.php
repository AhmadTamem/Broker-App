<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon; 
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Passwords;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\ApiCode;
use Illuminate\Support\Facades\Validator;



class ForgotPasswordController extends Controller
{
      /**
       * Write code on Method
       *
       * @return response()
       */


       ///         http://127.0.0.1:8000/forget-password
       

       // من هون لعند  send mail  هو forget password
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);
      
          $token = Str::random(64);
          $expirationTime = Carbon::now()->addMinutes(30); // مدة صلاحية التوكن هي نصف ساعة
  
          DB::table('password_reset_tokens')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now(),
              
          ]);
      
          Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('إعادة تعيين كلمة المرور');
          });
      
          return response()->json(['message' => 'لقد أرسلنا رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني!']);
      }
      
      public function showResetPasswordForm($token) { 
         return view('forgetPasswordLink', ['token' => $token]);
      }
      
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:8|confirmed',
              'password_confirmation' => 'required'
          ]);
         // - يتم البحث عن سجل في جدول password_reset_tokens حيث يكون البريد الإلكتروني مطابقًا، والرمز المميز مطابقًا،
                            // وتم إنشاؤه خلال الـ 30 دقيقة الماضية.
          $updatePassword = DB::table('password_reset_tokens')
          ->where([
              'email' => $request->email,
              'token' => $request->token,
          ])
          ->where('created_at', '>=', Carbon::now()->subMinutes(30))
          ->where('created_at', '<=', Carbon::now())
          ->first();
      
          if ($updatePassword) {
              $user = User::where('email', $request->email)
                          ->update(['password' => bcrypt($request->password)]);
      
              DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();
      
              return back()->with('password_changed', true);
          } else {
              return back()->withInput()->with('error', 'التوكن غير صالح أو منتهي الصلاحية!');
          }
      }
      ////////////////////////////////////////////////////////////////////////////sendVerificationEmail
      public function sendVerificationEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users',
    ]);

    $token = Str::random(64);
    $expirationTime = Carbon::now()->addMinutes(30); // مدة صلاحية التوكن هي نصف ساعة

    DB::table('email_verification_tokens')->insert([
        'email' => $request->email,
        'token' => $token,
        'created_at' => Carbon::now(),
        'expirationTime' => $expirationTime
    ]);

    // إرسال رسالة التحقق إلى البريد الإلكتروني للمستخدم
    Mail::send('email.verifyEmail', ['token' => $token], function($message) use($request){
        $message->to($request->email);
        $message->subject('Email Verification');
    });

    return response()->json(['message' => 'We have e-mailed you a verification link!']);
}

public function verifyEmail(Request $request)
{
    $request->validate([
        'token' => 'required|string|exists:email_verification_tokens'
    ]);
       // - يتم البحث عن سجل في جدول password_reset_tokens حيث يكون البريد الإلكتروني مطابقًا، والرمز المميز مطابقًا،
                            // وتم إنشاؤه خلال الـ 30 دقيقة الماضية.
    $verificationToken = DB::table('email_verification_tokens')
                            ->where('token', $request->token)
                            ->where('created_at', '>=', Carbon::now()->subMinutes(30))
                            ->where('created_at', '<=', Carbon::now())
                            ->first();

    if (!$verificationToken) {
        return response()->json(['message' => 'Invalid verification token!']);
    }

    $user = User::where('email', $verificationToken->email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found!']);
    }

    $user->email_verified_at = Carbon::now();
    $user->save();

    DB::table('email_verification_tokens')->where('token', $request->token)->delete();

    return view('email.verificationStatus', ['message' => 'Email verified successfully!']);
}


     /////////////////////////////////////////////////////////////////
     public function sendEmail(Request $request)
     {
         $request->validate([
             'email' => 'required',
         ]);
     
         Mail::send('layout', ['email' => $request->email], function ($message) use ($request) {
             $message->to($request->email);
             $message->subject('Welcome to our app!');
         });
     }
}