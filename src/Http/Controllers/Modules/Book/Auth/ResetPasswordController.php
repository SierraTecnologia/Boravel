<?php

namespace Boravel\Http\Controllers\Modules\Book\Auth;

use Boravel\Http\Controllers\Modules\Book\Controller;
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

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        parent::__construct();
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string $response
     * @return \Illuminate\Http\Response
     */
    protected function sendResetResponse($response)
    {
        $message = trans('auth.reset_password_success');
        session()->flash('success', $message);
        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }
}
