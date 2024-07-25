<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends AbstractFilter{
    
    public const ID = 'id';
    public const CODE = 'code';
    public const TOTAL = 'total';
    public const USER = 'user';
    public const STATUS = 'status';
    public const SDM = 'sdm';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const START =  'start';
    public const END = 'end';

    protected function getCallbacks(): array
    {
        return [
            self::ID => [$this,'id'],
            self::CODE => [$this,'code'],
            self::TOTAL => [$this,'total'],
            self::USER => [$this,'user'],
            self::STATUS => [$this,'status'],
            self::SDM => [$this,'sdm'],
            self::CREATED_AT => [$this,'created_at'],
            self::UPDATED_AT => [$this,'updated_at'],
            self::START => [$this, 'start'],
            self::END => [$this, 'end'],
        ];
    }
    
    public function id(Builder $builder, $value){
         $builder->where('id_order', 'like', "%{$value}%");
    }
    public function code(Builder $builder, $value){
        $builder->where('code', 'like', "%{$value}%");
    }
    public function total(Builder $builder, $value){
        $builder->where('total', 'like', "%{$value}%"); 
    }
    public function user(Builder $builder, $value){
         $builder->where('users.login', 'like', "%{$value}%");
    }
    public function status(Builder $builder, $value){
        if ($value !='Все'){
         $builder->where('statuses.id_status', 'like', "%{$value}%");
        }
    }
    public function sdm(Builder $builder, $value){
        if ($value !='Все'){
         $builder->where('sdms.id_sdm', 'like', "%{$value}%");
        }
    }
    public function created_at(Builder $builder, $value){
         $builder->where('orders.created_at', 'like', "%{$value}%");
    }
    public function updated_at(Builder $builder, $value){
         $builder->where('orders.updated_at', 'like', "%{$value}%");
    }
    public function start(Builder $builder, $value){
        $builder->where('orders.created_at','>=', $value);
    }
    
    public function end(Builder $builder, $value){
        $builder->where('orders.created_at','<=', $value);
    }



    
    
}