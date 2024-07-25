<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cart';

    protected $fillable = [
        'category_service_id',
        'user_id',
        'quantity',
        'price' 
    ];

    public $table = "carts";


    public function cservice(){
        return $this->belongsTo('App\Models\CategoryService','category_service_id','id_category_service');
    }
}
