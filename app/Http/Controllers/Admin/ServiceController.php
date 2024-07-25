<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\CategoryService;
use App\Models\Deadline;
use App\Models\Cart;
use App\Models\OrderItems;
use App\Models\ServiceDeliveryMethod;
use App\Models\Orders;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServiceController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:смотреть услуги через административную панель', ['only' => ['index']]);
        $this->middleware('permission:удалять услуги через административную панель', ['only' => ['destroy']]);
        $this->middleware('permission:обновлять услуги через административную панель', ['only' => ['update']]);
        $this->middleware('permission:создавать услуги через административную панель', ['only' => ['create','store']]);
        $this->middleware('permission:редактировать услуги через административную панель', ['only' => ['edit']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function index(Request $req)
    {
        $search = request()->query('search');
        if ($req->ajax()){
            $services = Service::where('name_service', 'LIKE', '%' . $req->search . '%')
            ->orWhere('description_service', 'LIKE', '%' . $req->search . '%')
            ->orderBy('id_service','desc')->paginate(10);
            return view('ajax.admin.services.index')->with(['services'=>$services])->render();
        }
        else if (isset($search)){
            $services = Service::where('name_service', 'LIKE', '%' . $search . '%')
            ->orWhere('description_service', 'LIKE', '%' . $search . '%')
            ->orderBy('id_service','desc')->paginate(10);
        }
        else{
            $services = Service::orderBy('id_service','desc')->paginate(10);  
        }
        return view('admin.service.index')->with([
        'services' => $services,
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('admin.service.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store (Request $request){
        $request->validate([
            'name_service' => 'required',
            'description_service' => 'required'
        ]);
        
        if (!Service::where('name_service', $request->name_service)->exists()){
        $new_service = new Service;
        $new_service->name_service = $request->name_service;
        $new_service->description_service = $request->description_service;
        $new_service->save();
        
        return redirect()->back()->with('status', 'Услуга успешно добавлена');
        }
        else {
            return  redirect()->back()->with('error', 'Такая услуга уже существует!');
        }
   }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.service.edit')->with([
            'service'=> $service,
        ]);
    }
     

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @param  \App\Models\Category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service, Deadline $deadline)
    {
        $service->name_service = $request->name_service;
        $service->description_service = $request->description_service;
        $service->update();
        return redirect()->back()->with('status', 'Услуга успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $categoryServiceIds = CategoryService::where('service_id', $service->id_service)->pluck('id_category_service')->toArray();
        Deadline::whereIn('category_service_id', $categoryServiceIds)->delete();
        Cart::whereIn('category_service_id', $categoryServiceIds)->delete();
        OrderItems::whereIn('category_service_id', $categoryServiceIds)->delete();
        CategoryService::where('service_id', $service->id_service)->delete();
        $service->delete();
        return redirect()->back()->with('status', 'Услуга успешно удалена');
    }

}
