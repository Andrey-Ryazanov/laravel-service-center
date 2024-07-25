<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ServiceDeliveryMethod;

class CategoryController extends Controller
{
    

    public function index()
    {
        $title = 'Каталог';
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('categories')->with([
            'parentCategories'  => $parentCategories,
            'title' =>  $title
          ]);
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('status', 'Категория успешно удалена');
    }

    public function view_category(Request $req, $title){

        if (Category::where('title',$title)->exists()){
            $category = Category::where('title',$title)->first();
            $subcategories = Category::where('parent_id',$category->id_category)->paginate(8);

            $query = Service::join('category_services as cs', 'id_service','cs.service_id')
            ->join('categories', 'cs.category_id', 'categories.id_category')
            ->join('deadlines','cs.id_category_service','=','deadlines.category_service_id')
            ->join('service_delivery_methods AS sdms','deadlines.sdm_id','=','sdms.id_sdm')
            ->where('cs.category_id',$category->id_category);
        

            $bySDM = request()->query('sdm');
            $search = request()->query('search');

            if ($bySDM!= ""){
                $sdm = explode(",",$bySDM);
            }
            if (isset($req->search) && isset($req->sdms)){
                $services = $query->whereIn('sdms.id_sdm',$req->sdms)->where('name_service','LIKE',"%{$req->search}%")->groupby('id_service')
                ->orderByRaw('FIELD(name_service, "Диагностика") DESC')->get();
            }
            else if (isset($req->search) && $req->ajax()){
                $services = $query->where('name_service','LIKE',"%{$req->search}%")->groupby('id_service')->orderByRaw('FIELD(name_service, "Диагностика") DESC')->get();
            }
            else if (isset($req->sdms)){
                $services = $query->whereIn('sdms.id_sdm',$req->sdms)->groupby('id_service')->orderByRaw('FIELD(name_service, "Диагностика") DESC')->get();
            }
            elseif (isset($sdm) && isset($search)){
                $services = $query->where('name_service','LIKE',"%{$search}%")->whereIn('sdms.id_sdm',$sdm)->groupby('id_service')
                ->orderByRaw('FIELD(name_service, "Диагностика") DESC')->get();
            }
            else if (isset($sdm)){
                $services = $query->whereIn('sdms.id_sdm',$sdm)->groupby('id_service')->orderByRaw('FIELD(name_service, "Диагностика") DESC')->get();
            }
            else if (isset($search)){
                $services = $query->where('name_service','LIKE',"%{$search}%")->groupby('id_service')->orderByRaw('FIELD(name_service, "Диагностика") DESC')->get();
            }
            else {
                $services = $query->groupby('id_service')->orderByRaw('FIELD(name_service, "Диагностика") DESC')->get();
            }
  
            $sdms = ServiceDeliveryMethod::all();
            
            if ($req->ajax()){
                return view('ajax.filter_services')->with([
                    'services'=>$services,
                ])->render();
            }
            else {
                return view('category.index')->with([
                    'category'=>$category,
                    'subcategories'=>$subcategories,
                    'services'=>$services,
                    'sdms' => $sdms,
                    'title' =>  $title
                ]);
            }
            
        }
        else {
            return redirect('/')->with('status',"Title does not exists!");
        }
    }
}