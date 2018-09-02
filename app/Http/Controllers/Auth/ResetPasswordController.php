<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/reset-success';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['showSuccessPage', 'change']);
    }

    /**
     * Reset user password
     *
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email|exists:password_resets,email',
            'password' => 'required|confirmed|min:6',
        ]);
        $record = DB::table('password_resets')->where('email', $request->email);

        if (\Hash::check($request->token, $record->first()->token)) {
            $record->delete();
            $user = User::where('email', $request->email)->first();
            $user->tokens()->delete();
            $user->password = bcrypt($request->password);
            $user->save();
            $user->createToken('Car Flow');

            return redirect($this->redirectTo);
        }

        return redirect()
                ->back()
                ->withInput()
                ->withErrors(['email' => ['Invalid token for current email']]);
    }

    /**
     * Update user password
     *
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if (\Hash::check($request->password, auth()->user()->password)) {
            $user = auth()->user();
            $user->tokens()->delete();
            $user->password = bcrypt($request->new_password);
            $user->save();
            $auth_token = $user->createToken('Car Flow')->accessToken;

            return response()->json(['auth_token' => $auth_token]);
        }

        return response()->json(['message' => 'Invalid user password']);
    }
    /**
     * Show message on success password reset
     *
     * @return void
     */
    public function showSuccessPage()
    {
        auth()->logout();
        return view('auth.passwords.reset-success');
    }
}
