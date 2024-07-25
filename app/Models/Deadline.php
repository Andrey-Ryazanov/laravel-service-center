<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Deadline extends Model
{
    use HasFactory;

    protected $primaryKey = ['category_service_id', 'sdm_id'];

    protected $fillable = [
        'deadline_start',
        'deadline_end'
    ];

    public $table = "deadlines";
    
    public $incrementing = false;

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('category_service_id', $this->getAttribute('category_service_id'))
            ->where('sdm_id', $this->getAttribute('sdm_id'));
    } 

    public function services(){
        return $this->belongsTo('App\Models\ServiceCategory','category_service_id','id_category_service');
    }

    public function sdms(){
        return $this->belongsTo('App\Models\ServiceDeliveryMethod','sdm_id','id_sdm');
    }

    
}