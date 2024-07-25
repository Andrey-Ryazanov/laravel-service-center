<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use App\Models\Service;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\StatusChange;
use App\Models\Status;
use App\Models\OrderItems;
use App\Models\ServiceDeliveryMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class OrderController extends Controller
{

    function __construct()
    {
        //Разрешения на работу с заказом
        $this->middleware('permission:смотреть свои заказы', ['only' => ['myOrders']]);
        $this->middleware('permission:оформлять заказ', ['only' => ['orderNow','orderPlace']]);
    }


    public function totalService($carts){
        $total = 0;
        foreach ($carts as $cart){
            $total += $cart->price * $cart->quantity;
        }
        return $total;
    }

    public function countService($carts){
        $result = '';
        $count = 0;
        foreach ($carts as $cart){
            $count += $cart->quantity;
        }
        if (11 <= $count %100 && $count %100 <=19){
            $result = str($count).' услуг';
        }
        elseif ($count % 10 == 1){
            $result = str($count).' услуга';
        }
        elseif (2 <= $count % 10  && $count % 10  <=4){
            $result = str($count).' услуги';
        }
        else{
            $result = str($count).' услуг';
        }
        return $result;
    }


    function orderNow(){
        $title = 'Оформление заказа';
        $user_id = Auth::user()->id_user;
        $query = Cart::with('cservice')
        ->where('user_id', $user_id);

        $sdms = session()->get('sdm');

        if (isset($sdms)){
            $carts = $query->whereHas('cservice.deadlines', function ($q) use ($sdms) {
                $q->where('sdm_id', $sdms[0]);
            })->get();

            return view('order.ordernow',[
                'sdm' => $sdms[0],
                'total' =>$this->totalService($carts),
                'count' =>$this->countService($carts),
                'title' => $title
            ]);
        }
        else {
                $carts = $query->get();
            }

        return view('order.ordernow',[
            'total' =>$this->totalService($carts),
            'count' =>$this->countService($carts),
            'title' => $title
        ]);
    }

    function orderPlace(Request $req){
        if (session()->get('sdm')){
            $sdm = session()->get('sdm')[0];
            $query = Cart::join('category_services','category_service_id','category_services.id_category_service')
            ->where('user_id',Auth::user()->id_user)
            ->join('deadlines','deadlines.category_service_id','category_services.id_category_service')
            ->where('deadlines.sdm_id',$sdm);
        }
        else{
            $query = Cart::where('user_id',Auth::user()->id_user);
        }
        $orderCode = strval(random_int(10000000, 99999999));
        while (Order::where('code', $orderCode)->exists()) {
            $orderCode = strval(random_int(10000000, 99999999));
        }

        $order = Order::create([
            'user_id' => Auth::user()->id_user,
            'sdm_id' => $sdm ?? 1,
            'comment' => $req->comment,
            'address' => $req->address,
            'total' => $query->sum(DB::raw('price * quantity')),
            'code' => $orderCode
            ]);
        
        $status = StatusChange::create([
            'order_id' => $order->id_order,
            'status_id' => 1
        ]);

        $allCart = $query->get();
        foreach($allCart as $cart){
            $orderItems = OrderItems::create([
                'category_service_id' => $cart['category_service_id'],
                'quantity'=> $cart['quantity'],
                'price' => $cart['price'],
                'order_id' => $order->id_order
            ]);
        }
        $query->delete();
        session()->forget('sdm');
        return redirect()->route('myorders');
    }

    function myOrderDetails($code){
       $title = 'Детали заказа';
       $order = Order::where('code',$code)->first();
       $orderItems = OrderItems::where('order_id', $order->id_order)->get();
       $categories = Category::join('category_services','id_category','category_services.category_id')
        ->join('services','category_services.service_id','services.id_service')
       ->join('order_items','category_services.id_category_service','order_items.category_service_id')
       ->join ('orders','orders.id_order','order_items.order_id')
       ->where('orders.id_order', $order->id_order)
       ->groupby('categories.id_category')
       ->select('categories.*')
       ->get();
        $services = Service::join('category_services','id_service','category_services.service_id')->get();
        $status = Status::join('status_change_history as sch','id_status','=','sch.status_id' )
        ->join('orders','sch.order_id','=','orders.id_order')->where('sch.order_id','=',$order->id_order) 
        ->select(DB::raw("*,max(sch.status_id) as id_status"))->first();
        $sdm = ServiceDeliveryMethod::join('orders', 'id_sdm', 'orders.sdm_id')->where('id_sdm', $order->sdm_id)->first();
        
       return view('order.myorderdetails',[
           'order'=> $order, 
           'orderItems' => $orderItems, 
           'services'=>$services,
           'status'=>$status,
           'sdm' => $sdm,
           'categories'=>$categories, 
           'total' =>$order->total,
           'count' =>$this->countService($orderItems),
           'title' => $title]);
    }

    function myOrders(Request $req){
         $title = 'Мои заказы';
         $subquery = StatusChange::select(DB::raw("order_id,max(status_id) as id_status, created_at as sc_created_at"))
        ->join('statuses','status_id','=','statuses.id_status')
        ->groupby('order_id');

        $query = Order::joinSub($subquery,'subquery', function($join){
            $join->on('id_order','=','subquery.order_id');
        })
        ->join('statuses','subquery.id_status','=','statuses.id_status')
        ->where('orders.user_id',Auth::user()->id_user);

        $byStatus = request()->query('status');
        $byInterval = request()->query('interval');
        if ($byStatus!= ""){
            $status = explode(",",$byStatus);
        }
        if ($byInterval != ""){
            $interval = explode(",",$byInterval);
        }

        if (isset($req->statuses) && isset($req->intervals)){
            $orders = $query->whereIn('subquery.id_status',$req->statuses)
            ->whereBetween('orders.created_at',$req->intervals)
            ->orderby('subquery.sc_created_at','desc')->paginate(5);
        }
        else if (isset($req->statuses)) {
            $orders = $query->whereIn('subquery.id_status',$req->statuses)->orderby('subquery.sc_created_at','desc')->paginate(5);
        }
        else if (isset($req->intervals)){
            $orders = $query->whereBetween('orders.created_at',$req->intervals)->paginate(5);
        }
        else if (isset($status) && isset($interval)){
            $orders = $query->whereIn('subquery.id_status',$status)
            ->whereBetween('orders.created_at',$interval)
            ->orderby('subquery.sc_created_at','desc')->paginate(5);
        }
        else if (isset($status)) {
            $orders = $query->whereIn('subquery.id_status',$status)->orderby('subquery.sc_created_at','desc')->paginate(5);
        }
        else if (isset($interval)){
            $orders = $query->whereBetween('orders.created_at',$interval)->paginate(5);
        }
        else {
            $orders = $query->orderby('subquery.sc_created_at','desc')->paginate(5);
        }

        $statuses = Status::all();

        foreach ($orders as $order){
            Carbon::setLocale('ru');
            $order->start = Carbon::parse($order->created_at)->isoFormat('D MMMM YYYY, HH:mm');
            $order->end = Carbon::parse($order->updated_at)->isoFormat('D MMMM YYYY, HH:mm');
        }

        if ($req->ajax()){
            $page = view('ajax.sortmyorders',[
                'statuses' => $statuses,
                'orders'=> $orders,
            ])->render();
            return response()->json([
                'page'=>$page, 
            ]
            )->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma','no-cache') ;
        }
        
        return view('order.myorders',[
            'statuses' => $statuses,
            'orders'=> $orders,
            'title' => $title
        ]);
   }
}

