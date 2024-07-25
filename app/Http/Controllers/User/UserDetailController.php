<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserDetailController extends Controller
{
    
    function __construct()
    {
        $this->middleware('permission:смотреть информацию о себе', ['only' => ['index']]);
        $this->middleware('permission:редактировать информацию о себе', ['only' => ['storeOrUpdate']]);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Личные данные';
        if (Auth::user()){
            $user = Auth::user();
            return view('user.personal',['personal'=>$user->personal, 'title' => $title]);
        }
    }
    
    public function storeOrUpdate(Request $request){
        $user = Auth::user();
        if ($user->personal()->exists()){
            $user->personal()->update([
                'surname'=>$request->surname,
                'name'=>$request->name,
                'patronymic'=>$request->patronymic,
                'address' => $request->address
            ]);
        }
        else {
            $user->personal()->create([
                'surname'=>$request->surname,
                'name'=>$request->name,
                'patronymic'=>$request->patronymic,
                'address' => $request->address
            ]);
        }
        return redirect('/my/personal')->with('status', 'Данные успешно обновлены');
    }
}
