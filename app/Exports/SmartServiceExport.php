<?php

namespace App\Exports;

use App\Models\Service;

use Illuminate\Http\Request;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SmartServiceExport implements FromView
{
    protected $request;
    
     public function __construct(Request $request){
         $this->request = $request;
     }
     
    public function view(): View
    {
        if (gettype($this->request->id_service) == "NULL" || $this->request->id_service =="Все"){
            $services = Service::all();
        }
        else{
            $services = Service::where('id_service', '=', $this->request->id_service)->get();
        }

        return view('admin.exports.services')->with([
            'services' => $services
        ]);
    }



}
