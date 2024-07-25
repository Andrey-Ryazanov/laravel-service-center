<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceContact;


class ServiceContactController extends Controller
{
    // Метод для отображения формы редактирования или создания контактных данных
    public function edit()
    {
        $contact = ServiceContact::first();
        return view('admin.contacts.edit', compact('contact'));
    }

    // Метод для создания или обновления контактных данных
    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'phone' => 'required|max:12',
            'address' => 'required|max:255',
            'start_working_hours' => 'required',
            'end_working_hours' => 'required',
        ]);

        $contact = ServiceContact::first();

        $data = $request->all();
        $data['start_working_hours'] = date('H:i', strtotime($request->start_working_hours));
        $data['end_working_hours'] = date('H:i', strtotime($request->end_working_hours));

        if ($contact) {
            $contact->update($data);
            $message = 'Контактные данные успешно обновлены!';
        } else {
            ServiceContact::create($data);
            $message = 'Контактные данные успешно созданы!';
        }

        return redirect()->route('contact.edit')->with('status', $message);
    }
}
