<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_orderItem';

    protected $fillable = [
        'service_id',
        'quantity',
        'price',
        'cost',
        'order_id',
        'category_service_id'
    ];

    public function service() {
        return $this->belongsTo('App\Models\CategoryService','category_service_id','id_category_service');
    }
}
