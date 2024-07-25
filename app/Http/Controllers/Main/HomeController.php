<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use App\Atricle;
use App\Category;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /* public function __construct()
    {
        $this->middleware('auth');
    } */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $parentCategories = \App\Models\Category::whereNull('parent_id')->get();
        return view('categories',[
            'parentCategories'=>$parentCategories,
            'title' => 'GadgetGenius — Главная',
        ]);
    }
    
   public function showCookiePolicy()
   {
       return view('document.cookie-policy',['title' => 'Политика использования cookie файлов']);
   }
   
    


    
}
