<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    
    public function purchases()
    {
        return $this->hasMany('App\Purchase');
    }
    
    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }
    
    public function sells()
    {
        return $this->hasMany('App\Sell');
    }
}
