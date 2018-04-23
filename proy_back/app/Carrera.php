<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    //
    protected $fillable = ['carrera', 'estado'];
    
    public function colaborador(){
        return $this->hasMany('App\Colaborador');
    }
}
