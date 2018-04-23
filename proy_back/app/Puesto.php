<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    //
    protected $table = 'puestos';
    protected $fillable = ['puesto','descripcion','estado'];
    
    public function colaboradores(){
        return $this->hasMany('App\Colaborador');
    }
}
