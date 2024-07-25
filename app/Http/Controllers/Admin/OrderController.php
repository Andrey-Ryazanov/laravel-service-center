<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\StatusChange;
use App\Models\Status;
use App\Models\OrderItems;
use App\Models\CategoryService;
use App\Models\Service;
use App\Models\ServiceDeliveryMethod;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use App\Filters\OrderFilter;
use Illuminate\Support\Facades\Log;

use App\Notifications\OrderStatusChanged;
use Illuminate\Support\Facades\Notification;


class OrderController extends Controller
{
      function __construct()
     {
         $this->middleware('permission:смотреть заказы через административную панель', ['only' => ['index']]);
         $this->middleware('permission:удалять заказы через административную панель', ['only' => ['destroy']]);
         $this->middleware('permission:изменять статус заказа', ['only' => ['updateStatus']]);
     }
    
    public function index(Request $req){
        $subquery = StatusChange::select(DB::raw("order_id,max(status_id) as id_status, created_at as sc_created_at"))
        ->join('statuses','status_id','=','statuses.id_status')
        ->groupby('order_id');

        $query = Order::joinSub($subquery,'subquery', function($join){
            $join->on('id_order','=','subquery.order_id');
        })
        ->join('statuses','subquery.id_status','=','statuses.id_status');
        
        $validated = $req->only(['id', 'code','user','total','status','sdm','start','end','created_at','updated_at']);
        
        $filter = app()->make(OrderFilter::class, ['queryParams'=>array_filter($validated)]);
        
        $orders = $query->join('users','user_id','users.id_user')
        ->join('service_delivery_methods as sdms', 'sdm_id', 'sdms.id_sdm')
        ->select('orders.*', 'subquery.sc_created_at', 'statuses.name_status', 'users.login','sdms.name_sdm','sdms.id_sdm')
        ->filter($filter)
        ->orderby('id_order','desc')->paginate(10);

        $statuses = Status::all();
        $sdms = ServiceDeliveryMethod::all();
        foreach ($orders as $order){
            Carbon::setLocale('ru');
            $order->status_created = Carbon::parse($order->sc_created_at)->setTimezone('Europe/Moscow')->isoFormat('D MMMM YYYY, HH:mm');
            $order->created= Carbon::parse($order->created_at)->setTimezone('Europe/Moscow')->isoFormat('D MMMM YYYY, HH:mm');
            $order->updated= Carbon::parse($order->updated_at)->setTimezone('Europe/Moscow')->isoFormat('D MMMM YYYY, HH:mm');
        }
         
        return view('admin.orders.index')->with(['orders'=>$orders, 'statuses'=>$statuses, 'sdms'=>$sdms]);
    }
    
    public function show($id){
        $subquery = StatusChange::select(DB::raw("order_id,max(status_id) as id_status, max(created_at) as sc_created_at"))
        ->join('statuses','status_id','=','statuses.id_status')
        ->groupby('order_id');

        $query = Order::joinSub($subquery,'subquery', function($join){
            $join->on('id_order','=','subquery.order_id');
        })
        ->join('statuses','subquery.id_status','=','statuses.id_status');
        
        $order = $query->join('users','user_id','users.id_user')
        ->leftJoin('users_details as ud', 'users.id_user','ud.user_id')
        ->join('service_delivery_methods as sdm', 'sdm_id', 'sdm.id_sdm')
        ->select('orders.*', 'subquery.sc_created_at', 'statuses.id_status', 'statuses.name_status', 'users.login','users.email', 'users.phone','ud.surname','ud.name','ud.patronymic','sdm.id_sdm','sdm.name_sdm')
        ->where('id_order',$id)->first();
        
        if ($order){
        $orderItems = OrderItems::where('order_id', $order->id_order)->get();
       $categories = Category::join('category_services','id_category','=','category_services.category_id')
        ->join('services','category_services.service_id','=','services.id_service')
       ->join('order_items','category_services.id_category_service','=','order_items.category_service_id')
       ->join ('orders','orders.id_order','=','order_items.order_id')
       ->where('orders.id_order', $order->id_order)
       ->groupby('categories.id_category')
       ->select('categories.*')
       ->get();
        $services = Service::join('category_services','id_service','category_services.service_id')->get();
        $sdms = ServiceDeliveryMethod::all();
        
        $statuses = Status::all();
        Carbon::setLocale('ru');
        $order->status_created = Carbon::parse($order->sc_created_at)->isoFormat('D MMMM YYYY, HH:mm');
        $order->created= Carbon::parse($order->created_at)->isoFormat('D MMMM YYYY, HH:mm');
        $order->updated= Carbon::parse($order->updated_at)->isoFormat('D MMMM YYYY, HH:mm');
        
        return view('admin.orders.show')->with([
            'order'=>$order, 
            'sdms' =>  $sdms,
            'statuses'=>$statuses, 
            'orderItems' => $orderItems, 
            'services'=>$services,
            'categories'=>$categories, 
            'total' =>$order->total,
            'count' =>$this->countService($orderItems)
            ]);
        }
        else {
            return redirect()->route('orders.index');
        }
        
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
    
    public function edit($id){
        $order = Order::find($id);
        $cservices = CategoryService::all();
        $services = Service::join('category_services as cs', 'id_service','cs.service_id')->groupby('id_service')->get();
        $categories = Category::join('category_services as cs', 'id_category','cs.category_id')->groupby('id_category')->get();
        
        return view('admin.orders.edit')->with([
        'order' => $order,
        'cservices' => $cservices,
        'services' => $services,
        'categories' =>  $categories
        ]);
    }
    
    public function sendOrderStatusChangedNotification($order, $status)
    {
        $user = User::where('id_user',$order->user_id)->first();
        $user->notify(new OrderStatusChanged($user, $order, $status));
    }
        
    public function updateStatus(Request $request){
        $status_id = $request->input('status_id');
        $order_id = $request->input('order_id');
        
        $subquery = StatusChange::select(DB::raw("order_id,max(status_id) as id_status, max(created_at) as sc_created_at "))
        ->join('statuses','status_id','=','statuses.id_status')
        ->groupby('order_id');

        $query = Order::joinSub($subquery,'subquery', function($join){
            $join->on('id_order','=','subquery.order_id');
        })
        ->join('statuses','subquery.id_status','=','statuses.id_status');
        
        $order = $query->where('id_order',$order_id)->first();
        
        $previous_status_id = $order->id_status;
        $previous_status = Status::where('id_status', $previous_status_id)->first();
        $next_status = Status::where('id_status', $status_id)->first();
        
        if ($next_status->previous_id != $previous_status_id) {
            return response()->json(['status'=>"Невозможно изменить статус на данный"]);
        }
        
        $statusHistory = new StatusChange;
        $statusHistory->order_id = $order->id_order;
        $statusHistory->status_id = $status_id;
        $statusHistory->save();
        if($next_status->name_status == "Завершён") {
            $order->end_date_fact = now();
            $order->save();
        }
        $order->touch();

        try {
            $this->sendOrderStatusChangedNotification($order, $next_status);
        } catch (\Exception $e) {
            Log::error('Произошла ошибка: '.$e->getMessage());
        }
        
        return response()->json(['status'=>"Статус успешно изменён"]);
    }
    
    public function updateDeadline(Request $request){
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $order_id = $request->input('order_id');
        $order = Order::find($order_id);
        $order->start_date = $start_date;
        $order->end_date_plan = $end_date;
        $order->save();
    }
    
    public function calculateDeadline(Request $request){
        $start_date = $request->input('start_date');
        $order_id = $request->input('order_id');
        $order = Order::find($order_id);
        $items= OrderItems::join('category_services as cs','category_service_id','=','cs.id_category_service')
        ->join('deadlines','cs.id_category_service','=','deadlines.category_service_id')
        ->where('order_id',$order->id_order)
        ->where('deadlines.sdm_id','=',$order->sdm_id)
        ->get();
        
        $result = Carbon::parse($start_date);
        foreach ($items as $item) {
           $start = Carbon::parse($item->deadline_start);
           $date = Carbon::parse($item->deadline_end); 
           $temp = $date->diff($start)->days;
           $temp *=  $item->quantity;
          $result = $result->addDays($temp);
        }
        
        $result = $result->format('Y-m-d H:i:s'); 
        
        return response()->json(['result'=> $result]);
    }
    
    
    
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        OrderItems::where('order_id', $order->id_order)->delete();
        StatusChange::where('order_id', $order->id_order)->delete();
        $order->delete();
        return redirect()->back()->with('status', 'Заказ успешно удален');
    }
}
