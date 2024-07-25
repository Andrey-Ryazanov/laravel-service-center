<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusChange extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_status_change';
    
    public $updated_at = false;

    public $table = "status_change_history";

    protected $fillable = [
        'order_id',
        'status_id',
        'created_at',
    ];

    public function orders(){
        return $this->belongsTo('App\Models\Order','order_id','id_order');
    }

    public function statuses(){
        return $this->belongsTo('App\Models\Status','status_id','id_status');
    }
}