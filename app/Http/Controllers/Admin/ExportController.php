<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\Deadline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Auth;
use Illuminate\Support\Collection;

use App\Exports\CategoryExport;
use App\Exports\SmartCategoryExport;
use App\Exports\ServiceExport;
use App\Exports\SmartServiceExport;
use Illuminate\Support\Facades\Storage;

use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller{
    
     function __construct()
     {
         $this->middleware('permission:экспортировать категории', ['only' => ['exportCat','categoriesExport','categoryExport']]);
         $this->middleware('permission:экспортировать услуги', ['only' => ['exportServ','servicesExport','serviceExport']]);
     }
    
     public function exportCat(){
        $categories = Category::all();
        return view('admin.category.export')->with([
        'categories'  => $categories
      ]);
    }
    
      public function categoriesExport(){
       return Excel::download(new CategoryExport, 'categories.xlsx');
    }
    
    public function categoryExport(Request $request){
       $categoryName = (Category::where('id_category',$request->parent_id)->first())->title ?? 'Категории';
       $login = Auth::user()->login;
       $currentDate = date('Y-m-d');
       $fileName = $categoryName .'_'.  $currentDate . '.xlsx';
       $path = 'users/' . 'export/' . $login . '/';
       Storage::disk('local')->makeDirectory($path);
       $i = 1;
       while (Storage::disk('local')->exists($path . $fileName)) {
           $fileName = $categoryName .'_'.  $currentDate . '(' . $i . ')' . '.xlsx';
           $i++;
       }
       Excel::store(new SmartCategoryExport($request), $path . $fileName);
        return response(Storage::disk('local')->get($path . $fileName))
        ->header('Content-Type', Storage::disk('local')->mimeType($path . $fileName))
        ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
    
    public function exportServ(){
        $services = Service::all();
        return view('admin.service.export')->with([
        'services'  =>  $services
      ]);
    }
    
    public function servicesExport(){
       $currentDate = date('Y-m-d');
       $fileName = 'Услуги' .'_'.  $currentDate . '.xlsx';
       return Excel::download(new ServiceExport, $fileName);
    }
    
    public function serviceExport(Request $request){
       $categoryName = (Service::where('id_service',$request->id_service)->first())->name_service ?? 'Услуги';
       $login = Auth::user()->login;
       $currentDate = date('Y-m-d');
       $fileName = $categoryName .'_'.  $currentDate . '.xlsx';
       $path = 'users/' . 'export/' . $login . '/';
       Storage::disk('local')->makeDirectory($path);
       $i = 1;
       while (Storage::disk('local')->exists($path . $fileName)) {
           $fileName = $categoryName .'_'.  $currentDate . '(' . $i . ')' . '.xlsx';
           $i++;
       }
       Excel::store(new SmartServiceExport($request), $path . $fileName);
        return response(Storage::disk('local')->get($path . $fileName))
        ->header('Content-Type', Storage::disk('local')->mimeType($path . $fileName))
        ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}