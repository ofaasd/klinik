<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

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
    protected $redirectTo = '/beranda';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $userRequired = [
            'username' => $request->username,
            'password' => $request->password
        ];

        $remember_me = $request->has('remember') ? true : false;
		$jenis = 0;

       if(Auth::attempt($userRequired, $remember_me)) {
            $jenis = \DB::table('sub_satuan_kerja')
                ->where('id','=',Auth::user()->sub_satuan_kerja_id)
                ->first()->jenis;
            \Session::put('user_jenis', $jenis);
        }
		
		
        if($jenis == 4){
            return redirect('/boyolali')
            ->withInput(Input::except('password'))
            ->withErrors(['gagal' => 'Opss ... Login gagal']);
        }else{
            return redirect('/')
            ->withInput(Input::except('password'))
            ->withErrors(['gagal' => 'Opss ... Login gagal']);
        }
    }

    public function logout()
    {
        Auth::logout();
        \Session::flush();
         return redirect('/');
    }
}
