<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryService extends Model
{
    use HasFactory;
    
    public $timestamps = false;
     
    public $table = "category_services";
     
    protected $primaryKey = 'id_category_service';

    protected $fillable = [
        'service_id',
        'category_id',
        'main_image',
        'created_at',
        'updated_at'
    ];
    
    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','id_category');
    }
    
    public function service(){
        return $this->belongsTo('App\Models\Service','service_id','id_service');
    }
    
    public function carts(){
        return $this->hasMany('App\Models\Cart','category_service_id','id_category_service');
    }

    public function orderItems(){
        return $this->hasMany('App\Models\OrderItems','category_service_id','id_category_service');
    }

    public function deadlines(){
        return $this->hasMany('App\Models\Deadline','category_service_id','id_category_service');
    }
}
