<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class CheckOrderAccess
{
    public function handle(Request $request, Closure $next)
    {
        $code = $request->route('code');
        $order = Order::where('code', $code)->first();
        $user = Auth::user();

        if ($user->can('смотреть детали своего заказа') && $user->id_user == $order->user_id || $user->can('иметь доступ к главной административной панели')){
            return $next($request);
        }
        else{
            return redirect()->route('myorders');
        }
    }
}