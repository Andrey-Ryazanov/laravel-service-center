<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Notifications\TwoFactorCode;

class TwoFactorController extends Controller
{
    public function index() 
    {
        return view('auth.twoFactor', ['title'=> 'Двухфакторная проверка']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);

        $user = auth()->user();

        if($request->input('two_factor_code') == $user->two_factor_code)
        {
            
            $user->resetTwoFactorCode();

            return redirect()->intended();
        }

        return redirect()->back()
            ->withErrors(['two_factor_code' => 
                'Введенный вами двухфакторный код не совпадает']);
    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());

        return redirect()->back()->withMessage('Двухфакторный код отправлен повторно');
    }
    
    public function enable()
    {
        $user = auth()->user();
        $user->two_factor_enabled = true;
    /*    $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode()); */
        $user->save();
    
        return redirect()->back()->withMessage('Двухфакторная аутентификация включена');
    }

    public function disable()
    {
        $user = auth()->user();
        $user->two_factor_enabled = false;
        $user->resetTwoFactorCode();
        $user->save();
    
        return redirect()->back()->withMessage('Двухфакторная аутентификация выключена');
    }
}