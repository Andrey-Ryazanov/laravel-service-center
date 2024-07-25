<?php

namespace App\Exports;

use App\Models\Service;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ServiceExport implements FromView
{
    public function view(): View
    {
        $services = Service::all();
        return view('admin.exports.services')->with([
            'services' => $services
        ]);
    }
}

