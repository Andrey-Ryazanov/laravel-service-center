<?php

namespace App\Exports;

use App\Models\Category;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CategoryExport implements FromView
{
    public function view(): View
    {
        $categories = Category::all();
        return view('admin.exports.categories')->with([
            'categories' => $categories
        ]);
    }
}
