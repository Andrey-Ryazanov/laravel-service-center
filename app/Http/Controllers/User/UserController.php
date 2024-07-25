<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:смотреть информацию о себе', ['only' => ['index','show']]);
        $this->middleware('permission:редактировать информацию о себе', ['only' => ['updateUser','updatePassword','changePassword']]);
    }

    public function index() 
    {
        $title = 'Безопасность';
		if (Auth::user()){
            $user_auth = new User;
            return view('user.security', ['data' => $user_auth->whereemail(auth()->user()->email)->get(),'title' => $title]);
        }
	    else {
		    return view('home');
	    }
    }
    
    
    public function show() 
    {
        $title = 'Данные аккаунта';
        if (Auth::user()){
            $user_auth = new User;
            return view('user.account', ['data' => $user_auth->whereemail(auth()->user()->email)->get(), 'title' => $title]);
        }
	    else {
		    return view('home');
	    }
    }

  public function updateUser(Request $request)
    {
        $user = Auth::user();
        
        if ($request->login == $user->login){
            $request->validate([
                'login' => 'required|string|max:255',
            ]);
        }
        else{
            $request->validate([
                'login' => 'required|string|max:255|unique:users',
            ]);
        }
        if ($request->email == $user->email){
            $request->validate([
                'email' => 'required|string|email|',
            ]);
        }
        else {
            $request->validate([
                'email' => 'required|string|email|unique:users,email',
            ]);
            $user->email = $request->email;
            $user->email_verified_at = null;
            
            if ($user->two_factor_enabled == true){
             $user->sendEmailVerificationNotification();
            }
        }
        if ($request->phone != ""){
            $request->validate([
                'phone' => 'numeric',
            ]);
        }
    
        $user->update([
            'login' => $request->login,
            'phone' => $request->phone
        ]);
    
    
        return redirect('/my/account')->with('status', 'Данные успешно обновлены');
    }

    public function changePassword(){
        $title = 'Смена пароля';
        return view('user.change-password', ['title' => $title]);
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required|confirmed|min:8',
        ]);


        #Match The Old Password
        if(!Hash::check($request->oldpassword, auth()->user()->password)){
            return back()->with("error", "Старый пароль не подходит!");
        }


        #Update the new Password
        User::whereid_user(auth()->user()->id_user)->update([
            'password' => Hash::make($request->newpassword)
        ]);

        return back()->with("status", "Пароль успешно изменён!");
    }
}
