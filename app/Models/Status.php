<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_status';

    protected $fillable = [
        'name_status',
        'previous_id'
    ];

    public function previous(){
        return $this->hasMany('App\Models\Status', 'previous_id');
    }

    public function status_changes(){
        return $this->hasMany('App\Models\StatusChange','status_id','id_status');
    }
}