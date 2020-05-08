<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = '/home';
    protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 2; // Default is 1
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock',
        ]);
    }

    public function locked()
    {
        if (!session('lock-expires-at')) {
            return redirect('/home');
        }
        if (session('lock-expires-at') > now()) {
            return redirect('/home');
        }
        return view('auth.locked');
    }

    public function unlock(Request $request)
    {
        $check = Hash::check($request->input('password'), $request->user()->password);
        if (!$check) {
            return redirect()->route('login.locked')
                ->withErrors([
                'password' => 'La contraseña ingresada es incorrecta.'
            ]);
        }
        session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);
        return redirect('/home');
    }

    public function username() {
        return 'username';
    }

    protected function redirectTo()
    {
        $user = \Auth::user();
        if ($user->app_roll == 'gestor_reque') {
            return '/Requerimientoss';
        }
        return '/home';
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('username', $request->input('username'))->first();

        if (auth()->guard('web')->attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {

            $new_sessid   = \Session::getId(); //get new session_id after user sign in

            if($user->session_id != '') {
                $last_session = \Session::getHandler()->read($user->session_id);

                if ($last_session) {
                    if (\Session::getHandler()->destroy($user->session_id)) {

                    }
                }
            }

            \DB::table('users')->where('id', $user->id)->update(['session_id' => $new_sessid]);

            $user = auth()->guard('web')->user();

            return redirect($this->redirectTo);
        }
        \Session::put('login_error', 'Your email and password wrong!!');
        return back();

    }

    public function logout(Request $request)
    {
        \Session::flush();
        \Session::put('success','you are logout Successfully');
        return redirect()->to('/login');
    }




}
