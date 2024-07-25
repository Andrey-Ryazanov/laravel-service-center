<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceDeliveryMethod;
use App\Models\Deadline;

class ServiceDeliveryMethodController extends Controller
{
    // Метод для отображения списка методов доставки
    public function index()
    {
        $sdms = ServiceDeliveryMethod::all();
        return view('admin.service_delivery_methods.index', compact('sdms'));
    }

    // Метод для отображения формы создания нового метода доставки
    public function create()
    {
        return view('admin.service_delivery_methods.create');
    }

    // Метод для сохранения нового метода доставки
    public function store(Request $request)
    {
        $request->validate([
            'name_sdm' => 'required|max:255',
        ]);

        ServiceDeliveryMethod::create($request->all());
        return redirect()->back()->with('status', 'Способ оказания услуги успешно создан!');
    }

    // Метод для отображения формы редактирования метода доставки
    public function edit($id_sdm)
    {
        $sdm = ServiceDeliveryMethod::findOrFail($id_sdm);
        return view('admin.service_delivery_methods.edit', compact('sdm'));
    }

    // Метод для обновления метода доставки
    public function update(Request $request, $id_sdm)
    {
        $request->validate([
            'name_sdm' => 'required|max:255',
        ]);

        $sdm = ServiceDeliveryMethod::findOrFail($id_sdm);
        $sdm->update($request->all());
        return redirect()->back()->with('status', 'Способ оказания услуги успешно обновлен!');
    }
    
     public function show(){
         
     }

    // Метод для удаления метода доставки
    public function destroy($id_sdm)
    {
        $sdm = ServiceDeliveryMethod::findOrFail($id_sdm);
        $deadline = Deadline::where('sdm_id', $id_sdm);
        $deadline->delete();
        $sdm->delete();
        return redirect()->back()->with('status', 'Способ оказания услуги успешно удален!');
    }
}
