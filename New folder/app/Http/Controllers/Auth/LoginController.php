<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        // dd($request);

        Auth::logout();
        Session::flush(); 
        return view('logout');
    }
  //old login method
    // public function login(Request $request)
    // {
    //     // dd($request);
    //     $credentials = $request->only('email', 'password');
    //     $remember = $request->has('remember'); 

    //     if (Auth::attempt($credentials, $remember)) {
    //        $session=auth::user();
    //        if($session->role_id == 2) {
            
    //         if(isset($request->remember)&&!empty($request->remember)){
    //             setcookie("email", $request->email, time() + (7 * 24 * 3600));
    //             setcookie("password", $request->password, time() + (7 * 24 * 3600));
    //         }else{
    //             setcookie("email", "", time() - 3600); // Expire cookie
    //           setcookie("password", "", time() - 3600); // Expire cookie
    //         }
    //            return redirect()->intended('/Memberhome');
    //        }else{
    //            return redirect()->intended('/home');
    //        }  
    //     } else {
    //         // Authentication failed
    //         return back()->withErrors(['email' => 'Invalid credentials']);
    //     }
    // }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $email = $request->email;
        $password = $request->password;
        $remember = $request->has('remember');
        $user = User::where('email', $email)->first();
    
        if (!$user) {
            return back()->with(['error' => 'Email does not exist'])->withInput();
        }
        if (!Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            return back()->with(['error' => 'Invalid password'])->withInput();
        }
        $session = Auth::user();
        if ($session->role_id == 2) {
            if (isset($request->remember) && !empty($request->remember)) {
                setcookie("email", $email, time() + (7 * 24 * 3600));
                setcookie("password", $password, time() + (7 * 24 * 3600));
            } else {
                setcookie("email", "", time() - 3600);
                setcookie("password", "", time() - 3600);
            }
            return redirect()->intended('/Memberhome');
        } else {
            return redirect()->intended('/home');
        }
    }
   
}
