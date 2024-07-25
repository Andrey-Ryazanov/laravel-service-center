<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\CategoryService;
use App\Models\Deadline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Exports\CategoryExport;
use App\Exports\SmartCategoryExport;
use App\Imports\SmartCategoryImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Auth;
use Illuminate\Support\Collection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
         $this->middleware('permission:смотреть категории через административную панель', ['only' => ['index']]);
         $this->middleware('permission:удалять категории через административную панель', ['only' => ['destroy']]);
         $this->middleware('permission:обновлять категории через административную панель', ['only' => ['update']]);
         $this->middleware('permission:создавать категории через административную панель', ['only' => ['create','store']]);
         $this->middleware('permission:редактировать категории через административную панель', ['only' => ['edit']]);
     }
     
    public function index(Request $req)
    {
        $search = request()->query('search');
        if (isset($req->search)) {
            $categories = Category::where('title', 'LIKE', '%' . $req->search . '%')
            ->orderBy('id_category','desc')->paginate(10);
        }
        else if (isset($search)){
            $categories =  Category::where('title', 'LIKE', '%' . $search . '%')
            ->orderBy('id_category','desc')->paginate(10);
        }
        else{
          $categories = Category::whereNull('parent_id')
            ->orderBy('id_category','desc')
            ->paginate(10);
        }
        
        if ($req->ajax()){
            return view('ajax.admin.categories.index')->with(['categories'=>$categories])->render();
        }
        
        //$parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.category.index')->with([
            'categories'  => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(){
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.category.create')->with([
        'categories'  => $categories
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_image' => 'image|mimes:jpeg,png,jpg',
            ]);

        $new_category = new Category;
        $new_category->title = $request->title;
        $new_category->parent_id = $request->parent_id;
        if($request->hasfile('category_image'))
        {
            $file = $request->file('category_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/categories/', $filename);
            $new_category['category_image'] = $filename;
        }
        $new_category->save();
        return redirect()->back()->with('status', 'Категория успешно добавлена');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    /*public function show(Category $category)
    {
        $parentCategories = \App\Models\Category::whereNull('parent_id')->get();
        return view('admin.category.index')->with([
        'parentCategories'  => $parentCategories
      ]);
    }*/

    public function show(Request $req, $title){
        if (Category::where('title',$title)->exists()){
            $category = Category::where('title',$title)->first();
            $search = request()->query('search');
            if ($req->ajax()){
                $asearch = $req->search;
                if (count($category->subcategory)>0) {
                $subcategories = Category::where('title', 'LIKE', '%' . $asearch . '%')
                ->where('parent_id', $category->id_category)
                ->orderBy('id_category','desc')->paginate(10);
                return view('ajax.admin.categories.subcategory')->with(['subcategories'=>$subcategories])->render();
                }
                else{
                    $services = CategoryService::join('services','service_id','services.id_service')
                    ->where(function($query) use ($asearch) {
                        $query->where('services.name_service', 'LIKE', '%' . $asearch . '%')
                              ->orWhere('services.description_service', 'LIKE', '%' . $asearch. '%');
                    })
                    ->where('category_id',$category->id_category)
                    ->orderBy('id_category_service','desc')
                    ->paginate(5);
                     return view('ajax.admin.category_services.index')->with(['services'=>$services])->render();
                }
            }
            else if (isset($search)){
                if (count($category->subcategory)>0) {
                    $subcategories =  Category::where('title', 'LIKE', '%' . $search . '%')
                    ->where('parent_id', $category->id_category)
                    ->orderBy('id_category','desc')->paginate(10);
                    $services = CategoryService::join('services','service_id','services.id_service')->where('category_id',$category->id_category)->paginate(5);
                }
                else{
                    $subcategories = Category::where('parent_id', $category->id_category)->orderBy('id_category','desc')->paginate(10);
                    $services = CategoryService::join('services','service_id','services.id_service')
                    ->where(function($query) use ($search) {
                        $query->where('services.name_service', 'LIKE', '%' . $search . '%')
                              ->orWhere('services.description_service', 'LIKE', '%' . $search. '%');
                    })
                    ->where('category_id',$category->id_category)
                    ->orderBy('id_category_service','desc')
                    ->paginate(5);
                }
            }
            else {
                $subcategories = Category::where('parent_id', $category->id_category)->orderBy('id_category','desc')->paginate(10);
                $services = CategoryService::join('services','service_id','services.id_service')->where('category_id',$category->id_category)->paginate(5);
            }
            
            return view('admin.category.subcategory')->with([
                'category'=>$category,
                'subcategories'=>$subcategories,
                'services'=>$services
            ]);
        }
        else {
            return redirect('/')->with('status',"Title does not exists!");
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.category.edit')->with([
        'categories'  => $categories,
        'category' => $category
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->title = $request->title;
        $category->parent_id = $request->parent_id;

        if($request->hasfile('category_image'))
        {
            $destination = 'uploads/categories/'.$category->category_image;
            if(file::exists($destination))
            {
                file::delete($destination);
            }
            $file = $request->file('category_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/categories/', $filename);
            $category['category_image'] = $filename;
        }
        $category->save();
        return redirect()->back()->with('status', 'Категория успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('status', 'Категория успешно удалена');

    }
}
