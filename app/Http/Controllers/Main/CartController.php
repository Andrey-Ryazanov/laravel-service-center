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
use App\Models\ServiceDeliveryMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class CartController extends Controller
{

    function __construct()
    {
        //Разрешения на работу с корзиной
        $this->middleware('permission:добавлять услугу в корзину', ['only' => ['addToCart']]);
        $this->middleware('permission:редактировать корзину', ['only' => ['updateCart']]);
        $this->middleware('permission:смотреть содержимое корзины', ['only' => ['cartList']]);
        $this->middleware('permission:удалять услугу из корзины', ['only' => ['removeCart']]);
    }

    public function addToCart(Request $request){
            $service_id = $request->input('service_id');
            $quantity = $request->input('quantity');
            
            if(Auth::user()){
                $service = CategoryService::join('services','service_id','services.id_service')
                ->join('categories','category_id','categories.id_category')
                ->join('deadlines','id_category_service','deadlines.category_service_id')
                ->where('id_category_service',$service_id)->first();

                $cart = Cart::where('category_service_id',$service_id)->where('user_id',Auth::user()->id_user)->first();
                if($cart){                      
                    $cart->quantity++;
                    $cart->price = $service->cost_service;
                    $cart->save(); 
                }
                else
                {
                    $cart = Cart::create([
                        'user_id' => Auth::user()->id_user,
                        'category_service_id' => $service_id,
                        'quantity' => $quantity,
                        'price' => $service->cost_service
                    ]);
                }
                $data = ['name' => $service->name_service, 'image' => $service->main_image, 'cost' => $service->cost_service ];
                return response()->json($data);
            }
            else
            {
                return redirect('/login');
            }
    }

    public function updateCart(Request $request){
        $service_id = $request->input('service_id');
        $quantity = $request->input('quantity');

        $service = CategoryService::join('services','service_id','services.id_service')
        ->join('categories','category_id','categories.id_category')
        ->join('deadlines','id_category_service','deadlines.category_service_id')
        ->where('id_category_service',$service_id)->first();
        
        $cart = Cart::where('category_service_id',$service_id)->where('user_id',Auth::user()->id_user)->first();
        if($quantity > 0){
            $cart->quantity = $quantity;
            $cart->price = $service->cost_service;
            $cart->save();
        }
        else {
            $this->removeCart($request);
            return response()->json(['status'=>"Услуга удалена из корзины"]);
        }
        return response()->json(['status'=>"Добавлено  <".$quantity."> услуг в корзину"]);
    }

    function cartList(Request $req){
        $title = 'Моя корзина';
        $user_id = Auth::user()->id_user;
        $query = CategoryService::join('carts', 'id_category_service','carts.category_service_id')
        ->join('services', 'services.id_service','=','service_id')
        ->join('categories','category_id','=','categories.id_category')
        ->join('deadlines','id_category_service','=','deadlines.category_service_id')
        ->where('carts.user_id','=', $user_id);
        
        $bySDM = request()->query('sdm');
        if ($bySDM!= ""){
            $sdm = explode(",",$bySDM);
            session()->put('sdm',$sdm);
        }

        if (isset($req->sdm)){
            $services = $query->where('deadlines.sdm_id',$req->sdm)->select('category_services.*','services.*', 'carts.*')->get();
        }
        else if (isset($sdm)){
            $services = $query->where('deadlines.sdm_id',$sdm)->select('category_services.*','services.*', 'carts.*')->get();
        }
        else{
            $services = $query->where('deadlines.sdm_id',1)->select('category_services.*','services.*', 'carts.*')->get();
        }
        
        $categories = $query->groupby('categories.id_category')->select('categories.*')->get();

        $page = view('cart.cartlist')->with([
            'services'=>$services,
            'categories'=>$categories,
            'total' =>$this->totalService($services),
            'count' =>$this->countService($services),
            'title' =>$title
        ]);

        if ($req->ajax()){
            $content = view('ajax.filter_cart')->with([
                'services'=>$services,
                'categories'=>$categories
            ])->render();

            $total = view('ajax.filter_cart_total')->with([                
                'total' =>$this->totalService($services),
                'count' =>$this->countService($services),
            ])->render();

            return response()->json([
                'content'=>$content, 
                'total' =>$total,
            ]
            )->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma','no-cache') ;
        }

        return $page;
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

    public function removeCart(Request $request)
    {
        $service_id = $request->input('service_id');
        $cart = Cart::where('category_service_id',$service_id)->where('user_id',Auth::user()->id_user)->first();

        if($cart){     
            $cart->delete();
        }
        return response()->json(['status'=>"Услуга удалена из корзины"]);
    }
}

