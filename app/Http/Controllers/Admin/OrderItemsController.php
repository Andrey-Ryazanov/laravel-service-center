<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Category;
use App\Models\OrderItems;
use App\Models\CategoryService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use App\Filters\OrderFilter;
use Illuminate\Support\Facades\Log;
use App\Notifications\AddOrderItem;

class OrderItemsController extends Controller
{
    function __construct()
     {
         $this->middleware('permission:добавить позицию в заказ', ['only' => ['addOrderItem']]);
         $this->middleware('permission:увеличить количество услуг в позиции заказа', ['only' => [' updateOrderItemsCount']]);
         $this->middleware('permission:удалить позицию из заказа', ['only' => ['removeItem']]);
     }
    
    public function updateOrderItemsCount(Request $request){
        $service_id = $request->input('service_id');
        $order_id = $request->input('order_id');
        $quantity = $request->input('quantity');
        
        $order = Order::where('id_order',$order_id)->first();
        $orderItem = OrderItems::where('order_id',$order_id)->where('category_service_id',$service_id)->first();
        if ($quantity > 0){
            $orderItem->quantity = $quantity;
            $orderItem->save();
            $order->total = OrderItems::where('order_id', $order_id)->sum(DB::raw('price * quantity'));
            $order->save();
        }
        else {
            $this->removeItem($request);
            return response()->json(['status'=>"Услуга удалена из заказа", 'service_id' => $service_id, 'order_id' => $order_id, 'quantity' => $quantity]);
        }
        return response()->json(['status'=>"Добавлено  <".$quantity."> услуг в заказ"]);
    }
    
    public function sendAddOrderItemNotification($order, $order_item)
    {
        $user = User::where('id_user',$order->user_id)->first();
        $user->notify(new AddOrderItem($user, $order, $order_item));
    }
    
    public function addOrderItem(Request $request)
    {
        $service_id = $request->service_id;
        $category_id = $request->category_id;
        $order_id = $request->order_id;
        $price = $request->cost;
        $quantity = $request->input('quantity');
        
        $cservice = CategoryService::where('service_id', $service_id)->where('category_id', $category_id)->first();
        $order = Order::where('id_order', $order_id)->first();
        
        $exist_order_item = OrderItems::where('category_service_id', $cservice->id_category_service)->where('order_id', $order_id)->first();
        if ($exist_order_item){
            $exist_order_item->quantity += $quantity;
            $exist_order_item->price = $price;
            $exist_order_item->save();
            
        }
        else {
            $order_item = new OrderItems();
            $order_item->category_service_id = $cservice->id_category_service;
            $order_item->order_id = $order_id ;
            $order_item->quantity = $quantity;
            $order_item->price = $price;
            $order_item->save();
        }
    
        if(isset($order_item) || isset($exist_order_item)) {     
            $new_price = OrderItems::where('order_id', $order_id)->sum(DB::raw('price * quantity'));
            $order->total = $new_price;
            $order->save();
        }
        $order_item = $order_item ?? $exist_order_item;
        try {
            $this->sendAddOrderItemNotification($order, $order_item);
        } catch (\Exception $e) {
            Log::error('Произошла ошибка: '.$e->getMessage());
        }
    
        return redirect()->route('orders.show', $request->order_id);
    }
    
    public function getServicesByCategory($category_id)
    {
        $services = Service::join('category_services as cs', 'id_service','cs.service_id')
                            ->where('cs.category_id', $category_id)
                            ->pluck('name_service', 'id_service');
        return response()->json($services);
    }
    
    public function calculateCost(Request $request)
    {
        $categoryService = CategoryService::where('category_id', $request->category_id)
                                           ->where('service_id', $request->service_id)
                                           ->first();
    
        return response()->json(['cost' => $categoryService->cost_service]);
    }
    
    public function removeItem(Request $request){
        $service_id = $request->input('service_id');
        $order_id = $request->input('order_id');
        $orderItem = OrderItems::where('order_id',$order_id)->where('category_service_id',$service_id)->first();
        $order = Order::where('id_order', $order_id)->first();

        if($orderItem) {     
            $orderItem->delete();
            $new_price = OrderItems::where('order_id', $order_id)->sum(DB::raw('price * quantity'));
            $order->total = $new_price;
            $order->save();
        }
        return response()->json(['status'=>"Услуга удалена из заказа"]);
    }
}
