<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use App\Models\CategoryService;

class Category extends Model
{
    use HasFactory;
    use HasRecursiveRelationships;
    
    public $timestamps = false;

    protected $primaryKey = 'id_category';

    protected $fillable = [
        'title',
        'category_image',
        'parent_id',
        'created_at',
        'updated_at'
    ];
    
    public function cservice(){
        return $this->hasMany('App\Models\CategoryService','category_id','id_category');
    }

    public function subcategory(){
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function getLevel($category){
        $level = 1;
        return $this->level($category, $level);
    }

    public function level($category, $level){
        if(isset($category->parent_id)){
            $parent = Category::where('id_category',$category->parent_id)->first();
        }
        if (isset($parent)){
            $level++;
            return $this->level($parent, $level);
        }
        return $level;
    }

    public function getFinalLevels($category){
        $result = '';
        $level = 1;
        return $this->Finallevel($category, $level,$result);
    }

    public function FinalLevel($category, $level, $result){
        if(isset($category->parent_id)){
            $parent = Category::where('id_category',$category->parent_id)->first();
        }
        if (isset($parent)){
            $result.=$level.'.';
            $level++;
            return $this->FinalLevel($parent, $level,$result);
        }
        return $result;
    }


    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function getParentsAttribute()
    {
        $parents = collect([]);
    
        $parent = $this->parent;
    
        while (!is_null($parent)) {
            $parents->prepend($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }
    

        
}
