<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceContact;

class ContactController extends Controller
{
    public function index(){
        // Получаем данные о сервисном центре из модели
        $serviceContact = ServiceContact::first();
        return view('contacts',['title'=>'Контакты', 'contacts'=> $serviceContact]);
    }
}
