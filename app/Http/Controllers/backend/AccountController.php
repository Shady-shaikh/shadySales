<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\AdminUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AccountController extends Controller
{
    //

    public function dashboard()
    {
        return view('backend.account.dashboard');
    }

    public function login()
    {
        $rememberToken = request()->cookie('remember_web_' . sha1(Auth::getDefaultDriver() . '_' . config('app.key')));
        return view('backend.account.login', compact('rememberToken'));
    }

    public function auth_user(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember, 'account_status', 1)) {
            if (isset(Auth()->guard('admin')->user()->id)) {
                if (Auth()->guard('admin')->user()->account_status == 0) {
                    Auth::guard('admin')->logout();
                    return back()->withErrors([
                        'message' => 'Your account has been deactivated, Please contact team to reactivate your account.'
                    ]);
                }
            }

            // Set remember token cookie if remember me is checked
            if ($request->remember) {
                $value = $request->email . '|' . $request->password;
                return redirect()->intended(route('admin.dashboard'))->withCookie(cookie()->forever('remember_web_' . sha1(Auth::getDefaultDriver() . '_' . config('app.key')), $value));
            } else {
                // Remove remember token cookie if remember me is unchecked
                return redirect()->intended(route('admin.dashboard'))->withCookie(cookie()->forget('remember_web_' . sha1(Auth::getDefaultDriver() . '_' . config('app.key'))));
            }
        } else {
            return back()->withErrors([
                'message' => 'The email or password is incorrect, please try again'
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('message', 'Logout Successfully');
    }

    public function forgot_password()
    {
        return view('backend.account.forgot_password');
    }
    public function recover_password(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        $user = AdminUsers::where('email', $request->email)->first();
        $user->password = env('DEFAULT_PASSWORD');
        $user->save();
        $subject = 'Reset Password For Your Account';
        $body = 'Hi, ' . $user->full_name . '<br> Please Find Your New Password Below <br>
        <b> Password: ' . env('DEFAULT_PASSWORD');
        send_email($request->email, $subject, $body);
        return redirect()->back()->with('message', 'Please Check Your Email For New Password');
    }
}
