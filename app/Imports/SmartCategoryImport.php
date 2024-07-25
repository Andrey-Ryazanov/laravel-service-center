<?php

namespace App\Imports;

use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class SmartCategoryImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $ids = [];
        $parentids = [];
        $categories = Category::all();
        
        foreach ($categories as $category){
            array_push($ids, $category->id_category);
        }
        
        foreach ($rows as $row) 
        {
            $id = $row['ID'];
            $title = $row['Название'];
            $category_image = $row['Изображение'];
            $parent_id  = $row['Родительский ID'];
        
            $parent = Category::where('id_category', $parent_id)->first();
        
            $category = new Category;
            if (!in_array($id, $ids)){
                $category->id_category = $id;
                $category->title = $title;
                $category->category_image = $category_image;
                $category->parent_id = $parent ? $parent_id : null;
                $category->save();
            }
            else {
                $category = Category::where('id_category', $id)->first();
                $category->update([
                    'title' => $title,
                    'category_image' => $category_image,
                    'parent_id' =>  $parent ? $parent_id : null,
                ]);
            }
            array_push($parentids, $row['ID']);
        }
        foreach ($rows as $row){
            if (in_array($row['Родительский ID'],$parentids)){
                Category::where('id_category', $row['ID'])->update([
                    'parent_id' => $row['Родительский ID']    
                ]);
            }
        }
    }
    }
