<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    function __construct()
     {
         $this->middleware('permission:иметь доступ к главной административной панели', ['only' => ['index']]);
     }
    function index() {
        $users_count = User::where('created_at', '>', Carbon::now()->subWeek())->count();
        $orders_count = Order::where('created_at', '>', Carbon::now()->subWeek())->count();
        return view('admin.home.admin',[
            'users_count'=>$users_count,
            'orders_count'=>$orders_count
        ]);
    }
}
