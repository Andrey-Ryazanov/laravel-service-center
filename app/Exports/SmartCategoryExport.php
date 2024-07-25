<?php

namespace App\Exports;

use App\Models\Category;

use Illuminate\Http\Request;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SmartCategoryExport implements FromView
{
    protected $request;
    
     public function __construct(Request $request){
         $this->request = $request;
     }
     
    public function view(): View
    {
        if (gettype($this->request->parent_id) == "NULL" || $this->request->parent_id =="Все"){
            $categories = Category::all();
        }
        else{
            $parentCategory = Category::find($this->request->parent_id);

            $categories= [];
            $this->getDescendants($parentCategory,  $categories);
        }

        return view('admin.exports.categories')->with([
            'categories' => $categories
        ]);
    }
    
    function getDescendants($category, &$descendants) {
    foreach ($category->children as $child) {
        $descendants[] = $child;
        $this->getDescendants($child, $descendants);
    }
    }


}
