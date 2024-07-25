<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDeliveryMethod extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_sdm';

    protected $fillable = [
        'name_sdm',
        'created_at',
        'updated_at'
    ];

    public $table = "service_delivery_methods";


    public function deadlines(){
        return $this->hasMany('App\Models\ServiceDeliveryMethod','sdm_id','id_sdm');
    }

    public function orders(){
        return $this->hasMany('App\Models\ServiceDeliveryMethod','sdm_id','id_sdm');
    }
}