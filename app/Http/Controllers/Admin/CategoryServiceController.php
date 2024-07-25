<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service;
use App\Models\CategoryService;
use App\Models\Cart;
use App\Models\OrderItems;
use App\Models\Deadline;
use App\Models\ServiceDeliveryMethod;
use App\Models\Orders;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryServiceController extends Controller
{
    public function index(Request $req)
    {
        $search = request()->query('search');
        if ($req->ajax()){
            $services = CategoryService::join('services','id_service','service_id')
            ->where('name_service', 'LIKE', '%' . $req->search . '%')
            ->orWhere('description_service', 'LIKE', '%' . $req->search . '%')
            ->orderBy('id_service','desc')
            ->paginate(5);
             return view('ajax.admin.category_services.index')->with(['services'=>$services])->render();
        }
        else if (isset($search)){
            $services = CategoryService::join('services','id_service','service_id')
            ->where('name_service', 'LIKE', '%' . $search . '%')
            ->orWhere('description_service', 'LIKE', '%' . $search. '%')
            ->orderBy('id_service','desc')
            ->paginate(5);
        }
        else {
            $services = CategoryService::join('services','id_service','service_id')->orderBy('name_service','asc')->paginate(5);
        }
        return view('admin.category_service.index')->with([
            'services' => $services,
        ]
        );
    }
    
    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('subcategory')->get();
        $sdms = ServiceDeliveryMethod::all();
        $services = Service::all();
        return view('admin.category_service.create')->with([
        'categories' => $categories,
        'sdms'=>$sdms,
        'periods' => $this->libraryPeriods(),
        'services'=>$services
    ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'service_id' => 'required',
            'cost_service' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg'
        ]);
        
        if (!CategoryService::join('services','service_id','services.id_service')->join('categories','category_id','categories.id_category')->where('service_id',$request->service_id)->where('category_id',$request->category_id)->exists()){
        $new_service = new CategoryService;
        $new_service->category_id = $request->category_id;
        $new_service->service_id = $request->service_id;
        $new_service->cost_service = $request->cost_service;
        
        if($request->hasfile('main_image'))
        {
            $file = $request->file('main_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/services/', $filename);
            $new_service['main_image'] = $filename;
        }
        $new_service ->save();
            
    
        $dates = $this->ValidateData($request->durings,$request->input('during_periods'));
        
        $sdms = $request->input('sdms');
        $nullDate = Carbon::create(0001,01,01);
        if (isset($sdms)){
            $size = count($sdms);
            for ($i=0; $i< $size; $i++){
                if ($dates[$i]!=$nullDate){
                    $deadline = new Deadline;
                    $deadline->category_service_id = $new_service->id_category_service;
                    $deadline->sdm_id = $sdms[$i];
                    $deadline->deadline_start = $nullDate;
                    $deadline->deadline_end = $dates[$i];
                    $deadline->save();
                }             
            }
        }
        return redirect()->back()->with('status', 'Услуга успешно добавлена');
        }
        else {
            return  redirect()->back()->with('error', 'Такая услуга уже существует!');
        }
    }

    function ValidateData($durings,$periods){
        $array = [
            "дни" => 1,
            "недели" => 7,
            "месяцы"=> 30,
            "года"=>365
        ];

        $middle = [];
        $result = [];
        $date = [];

        if (!empty($durings)){
            //$size = sizeof($array);
                foreach ($periods as $period){
                    foreach ($array as $item => $item_count){
                        if ($period == $item){
                            array_push($middle, $item_count);
                        }
                    }
                }
            $size = sizeOf($middle);

            for ($i = 0; $i < $size; $i++){
                $result[] = $durings[$i] * $middle[$i];
            }

            foreach ($result as $res){
                if ($res > 0){
                    $dt = Carbon::create(0001, 01, 01);
                    $dt->addDays($res);
                    $dt->format("Y-m-d");
                    array_push($date,date($dt));
                }
            }

            return $date;
        }
    }
    
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryService  $service
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //$categories = Category::orderBy('id_category','asc')->get();
        $categories = Category::whereNull('parent_id')->get();
        $allservices = Service::all();
        $service = CategoryService::findOrFail($id);
        
        $dates = DB::table('deadlines')
        ->join('category_services','deadlines.category_service_id','=','category_services.id_category_service')
        ->join('service_delivery_methods AS sdms','sdms.id_sdm','=','deadlines.sdm_id')
        ->where('deadlines.category_service_id',$service->id_category_service)
        ->get();

        $service = $service->join('services','service_id','services.id_service')->join('categories', 'category_id', 'categories.id_category')->where('id_category_service',$service->id_category_service)->first();

        $sdms = ServiceDeliveryMethod::all();

        foreach ($dates as $date){
            $intervals = $this->UnValidateData($date->deadline_start,$date->deadline_end);
            foreach ($intervals as $key => $value){
                $date->durings = $key;
                $date->periods = $value;
            }
        }

        return view('admin.category_service.edit')->with([
            'service'=>$service,
            'allservices'=>$allservices,
            'categories' => $categories,
            'dates' => $dates,
            'sdms' =>$sdms,
            'periods' => $this->libraryPeriods(),
        ]);
    }
    
     function UnValidateData($start,$end){
        $middle = [];
        $durPeriods = [];
        $result = [];
        
        $array = [
            "дни" => 1,
            "недели" => 7,
            "месяцы"=> 30,
            "года"=>365
        ];

        $end = Carbon::parse($end);

        $elem = ($end->diff($start)->days);
        if ($elem > 0){
            array_push($middle, $elem);
        }
        else {
            array_push($middle,0);
        }

        foreach ($middle as $mid){
            foreach ($array as $item => $item_count){
                if ($mid % $item_count == 0){
                    $number = intdiv($mid,$item_count);
                    $durPeriods += [$number=>$item];
                }
            }
            foreach ($durPeriods as $key => $value) {
                if($key == min(array_keys($durPeriods))){       
                    $result += [$key=>$value];
                }
            }
            $durPeriods = [];
        }
    
        return $result;
    }

    function libraryPeriods(){
        $arrayPeriods = [
            'дни',
            'недели',
            'месяцы'
        ];
        return $arrayPeriods;
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryService  $service
     * @param  \App\Models\Category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Deadline $deadline)
    {
        $request->validate([
            'category_id' => 'required',
            'service_id' => 'required',
            'cost_service' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg'
        ]);
        $service = CategoryService::findOrFail($id);
        
        $service = $service->join('services','service_id','services.id_service')->join('categories', 'category_id', 'categories.id_category')->where('id_category_service',$service->id_category_service)->first();
        $notExists = !CategoryService::join('services','service_id','services.id_service')->join('categories','category_id','categories.id_category')->where('service_id',$request->service_id)->where('category_id',$request->category_id)->exists();
        if($notExists || ($service->service_id == $request->service_id && $service->category_id == $request->category_id) ){
            $service->category_id = $request->category_id;
            $service->service_id = $request->service_id;
            $service->cost_service = $request->cost_service;
            
            if($request->hasfile('main_image'))
            {
                $destination = 'uploads/services/'.$service->main_image;
                if(file::exists($destination))
                {
                    file::delete($destination);
                }
                $file = $request->file('main_image');
                $extention = $file->getClientOriginalExtension();
                $filename = time().'.'.$extention;
                $file->move('uploads/services/', $filename);
                $service['main_image'] = $filename;
            }
            $service->update();
    
            $dates = $this->ValidateData($request->durings,$request->input('during_periods')); 
            $sdms = $request->input('sdms');
            $nullDate = Carbon::create(0001,01,01);
    
            if (isset($sdms)){
                for ($i = 0; $i< count($sdms); $i++){
    
                    /*Ищем, есть ли в таблице Deadlines значение из нажатой кнопки
                    с выбранной услугой, возвращаем 1 найденное значение
                    */
                    $deadline = Deadline::where('deadlines.sdm_id',$sdms[$i])
                    ->where('deadlines.category_service_id',$service->id_category_service)
                    ->first();
    
                    //Если мы получили элемент
                    if (isset($deadline)){
                        //если обработанная дата не пуста
                        if ($dates[$i] != $nullDate){
                            //обновляем дату в таблице Deadline 
                            $deadline->deadline_end = $dates[$i];
                            $deadline->update();
                        }
                    }
                    else {
                        //Если такой записи в Deadlines нет, то создаём её          
                        if ($dates[$i] != $nullDate){
                            $deadline_ = new Deadline;
                            $deadline_->category_service_id = $service->id_category_service;
                            $deadline_->sdm_id = $sdms[$i];
                            $deadline_->deadline_start = $nullDate;
                            $deadline_->deadline_end = $dates[$i];
                            $deadline_->save();
                        }
                    }
                }
                //Если кнопка не нажата, удаляем запись из БД
                Deadline::whereNotIn('deadlines.sdm_id',$sdms)
                ->where('deadlines.category_service_id', $service->id_category_service)
                ->delete();
            }
            else 
            {
                //Если ни одна кнопка не нажата, удаляем все способы оказания для услуги
                Deadline::where('deadlines.category_service_id',$service->id_category_service)
                ->delete();
            }
        }
        else {
            return  redirect()->back()->with('error', 'Такая услуга уже существует!');
        }
        return redirect()->back()->with('status', 'Услуга успешно обновлена');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryService  $service
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryService $service)
    {
        //
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryService  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = CategoryService::findOrFail($id);
        Deadline::where('category_service_id',$service->id_category_service)->delete();
        Cart::where('category_service_id',$service->id_category_service)->delete();
        OrderItems::where('category_service_id',$service->id_category_service)->delete();
        $service->delete();
        return redirect()->back()->with('status', 'Услуга успешно удалена');
    }
}
