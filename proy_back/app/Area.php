<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    protected $fillable = ['area', 'descripcion'];
    
    public function colaborador(){
        return $this->hasMany('App\Colaborador');
    }
}
