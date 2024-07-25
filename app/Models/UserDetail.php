<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
      
    protected $table = 'users_details';
    
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'address',
        'created_at',
        'updated_at'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id_user');
    }
}
