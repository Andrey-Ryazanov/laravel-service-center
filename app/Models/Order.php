<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use Filterable;

    protected $primaryKey = 'id_order';

    protected $fillable = [
        'user_id',
        'sdm_id',
        'comment',
        'address',
        'code',
        'total',
        'created_at',
        'updated_at',
    ];

    public function items() {
        return $this->hasMany('App\Models\OrderItems','order_id','id_order');
    }

    public function status_changes(){
        return $this->hasMany('App\Models\StatusChange','order_id','id_order');
    }

    public function sdm(){
        return $this->belongsTo('App\Models\Order','sdm_id','id_sdm');
    }
}
