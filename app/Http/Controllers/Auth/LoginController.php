<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import Log facade

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Determine if the input is an email or name
        $loginType = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // Attempt to log the user in
        $credentials = [
            $loginType => $request->input('email'),
            'password' => $request->input('password')
        ];

        Log::info('Login attempt with ' . $loginType . ': ' . $request->input('login'));

        if (Auth::attempt($credentials)) {
            // Authentication passed
            $user = Auth::user();
            $isFirstLogin = is_null($user->derniere_login);

            // Update the last login time
            $user->derniere_login = now();
            $user->save();

            Log::info('User\'s derniere_login updated: ' . $user->derniere_login);

            if ($isFirstLogin) {
                // Redirect to the depot settings page if it's the user's first login
                return redirect()->route('depot.settings');
            }

            return redirect()->intended($this->redirectTo);
        }

        // Authentication failed, redirect back with an error message
        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }
}
