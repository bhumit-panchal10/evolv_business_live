<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;



class ForgotPasswordController extends Controller
{
     /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
       
         return view('auth/forgetPassword');
      }
  
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
  
          $token = Str::random(10);
  
          $url = route('resetpassword', $token);
          $data =array(
             'email' => $request->email, 
             'token' => $token,             
             ) ;
             DB::table('password_resets')->insert($data);

            $SendEmailDetails = DB::table('sendemaildetails')
              ->where(['id' => 8])
              ->first();
            $msg = array(
              'FromMail' => $SendEmailDetails->strFromMail ?? 'info@getdemo.in',
              'Title' => $SendEmailDetails->strTitle ?? 'Evolve Business Community',
              'ToEmail' =>$request->email,
              'Subject' => $SendEmailDetails->strSubject ?? 'Forget Password'
            );
            $Link = url('https://Groath.in/resetpassword/' . $token);
            $data = [
              'Link' => $Link,
            ];
            $mail = Mail::send('emails.forgetpassword', ['data' => $data], function ($message) use ($msg) {
              $message->from($msg['FromMail'], $msg['Title']);
              $message->to($msg['ToEmail'])->subject($msg['Subject']);
          });
          return back()->with('success', 'We have e-mailed your password reset link!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 

        $email = DB::table('password_resets')
        ->where('token', $token)
        ->value('email');
        // dd($email);
        return view('resetpasswordform',compact('token','email'));
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
        // dd($request);

          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
          return redirect()->route('Frontfront-login')->with('success', 'Your password has been changed!');

      }
}
