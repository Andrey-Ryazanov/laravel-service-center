<?php

namespace App\Http\Controllers\Admin;

use App\Imports\SmartCategoryImport;
use App\Imports\SmartServiceImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Auth;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    function __construct()
     {
         $this->middleware('permission:импортировать категории', ['only' => ['importCat','categoryImport']]);
         $this->middleware('permission:импортировать изображения категорий', ['only' => ['importImagesCat']]);
         $this->middleware('permission:импортировать услуги', ['only' => ['importServ','serviceImport']]);
         $this->middleware('permission:импортировать изображения услуг', ['only' => ['importImagesServ']]);
     }
    
    public function importCat(){
        return view('admin.category.import');
    }
    
    public function categoryImport(Request $request){
        Excel::import(new SmartCategoryImport, $request->file('category_file'));
        
        return redirect()->back()->with('success', 'Файл загружен успешно!');
    }
    
    public function importImagesCat(Request $request){
        $validated = $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg'
        ]);
        foreach ($validated['images'] as $file){
            $name = $file->getClientOriginalName();
            $filename = pathinfo($name, PATHINFO_FILENAME) . '.png';
            $filepath = 'uploads/categories/' . $filename;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            $file->move('uploads/categories/', $filename);
        }

        return redirect()->back()->with('success', 'Изображения загружены успешно!');
    }
    
      public function importServ(){
        return view('admin.service.import');
    }
    
    public function serviceImport(Request $request){
        $validated = $request->validate([
        'service_file' => 'file|mimes:xlsx,xls'
        ]);
        Excel::import(new SmartServiceImport, $request->file('service_file'));
        
        return redirect()->back()->with('success', 'Файл загружен успешно!');
    }
    
        
    public function importImagesServ(Request $request){
        $validated = $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg'
        ]);
        foreach ($validated['images'] as $file){
            $name = $file->getClientOriginalName();
            $filename = pathinfo($name, PATHINFO_FILENAME) . '.png';
            $filepath = 'uploads/services/' . $filename;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            $file->move('uploads/services/', $filename);
        }

        return redirect()->back()->with('success', 'Изображения загружены успешно!');
    }
}
