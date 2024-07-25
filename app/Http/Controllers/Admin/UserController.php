<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\StatusChange;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Registered;
use Hash;


class UserController extends Controller
{

    function __construct()
    {
       // $this->middleware('permission:смотреть информацию о пользователях', ['only' => ['index']]);
        $this->middleware('permission:редактировать информацию о пользователях', ['only' => ['edit','update']]);
        $this->middleware('permission:создавать пользователей', ['only' => ['create','store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index(Request $req)
    {
        if (auth()->user()->can('смотреть информацию о пользователях')){
             $search = request()->query('search');
            if ($req->ajax()){
                $users = User::where('login', 'LIKE', '%' . $req->search . '%')
                ->orWhere('email', 'LIKE', '%' . $req->search . '%')
                ->orWhere('phone', 'LIKE', '%' . $req->search . '%')
                ->orderBy('id_user','desc')->paginate(10);
                return view('ajax.admin.users.index')->with(['users'=>$users])->render();
            }
            else if (isset($search)){
                $users = User::where('login', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'LIKE', '%' . $search . '%')
                ->orderBy('id_user','desc')->paginate(10);
            }
            else{
                $users = User::orderBy('id_user','desc')->paginate(10);  
            }
            $users_count = User::all()->count();
            return view('admin.users.index')->with([
            'users' => $users,
            'users_count'=>$users_count,
            ]);
        }
        else{
            return redirect('/');
        }
    }


    public function create()
    {
        $roles = Role::all()->pluck('name');
        return view('admin.users.create',[
        'roles' => $roles]
    );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|unique:users',
            'phone' => 'numeric',
            'roles' => 'required',
            'password' => 'required|string|min:8',
        ]);
    
        $input['login'] = $request->input('login');
        $input['email'] = $request->input('email');
        $input['phone'] = $request->input('phone');
        $input['password'] = Hash::make($request->input('password'));
    
        $user = User::create($input);
        event(new Registered($user));
        $user->assignRole($request->input('roles'));

        return redirect('administration/usAbout')->with('status', 'Пользователь успешно создан');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all()->pluck('name');
        return view('admin.users.edit')->with([
            'user'=>$user,
            'roles'=>$roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
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
        }
        if ($request->phone != ""){
            $request->validate([
            'phone' => 'numeric',
            ]);
        }
        $request->validate([
            'roles' => 'required'
        ]);

        $user->update([
            'login' => $request->login,
            'email' => $request->email,
            'phone' => $request->phone,
            ]);
            
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect('administration/usAbout')->with('status', 'Пользователь успешно отредактирован');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Cart::where('user_id', $user->id_user)->delete();
        $orders = Order::where('user_id', $user->id_user)->get();
        foreach ($orders as $order) {
            OrderItems::where('order_id', $order->id_order)->delete();
            StatusChange::where('order_id', $order->id_order)->delete();
            $order->delete();
        }
        $user->delete();
        return redirect()->back()->with('status', 'Пользователь успешно удален');
    }

}




