<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $primaryKey = 'id_service';

    protected $fillable = [
        'name_service',
        'description_service',
        'created_at',
        'updated_at'
    ];

   /* public function category(){
        return $this->belongsTo('App\Models\Category','category_id','id_category');
    }
    
    public function carts(){
        return $this->hasMany('App\Models\Cart','service_id','id_service');
    }

    public function orderItems(){
        return $this->hasMany('App\Models\OrderItems','service_id','id_service');
    }

    public function services(){
        return $this->hasMany('App\Models\Deadline','service_id','id_service');
    } */
}
