<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class TwoFactor
{
    /* 
    *@param  string|null  $redirectToRoute
    */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        
        if (auth()->check() && $user->email_verified_at == NULL && $user->two_factor_enabled == true){
            return Redirect::guest(URL::route('verification.notice'));
        }
    
        if(auth()->check() && $user->two_factor_code)
        {
            if(Carbon::parse($user->two_factor_expires_at) < now())
            {
                $user->resetTwoFactorCode();
                $user->save();
                auth()->logout();
    
                return redirect()->route('login')
                    ->withMessage('Срок действия двухфакторного кода истек. Пожалуйста, войдите снова.');
            }
            if(!$request->is('verify*'))
            {
                return redirect()->route('verify.index');
            }
        }
        return $next($request);
    }
}