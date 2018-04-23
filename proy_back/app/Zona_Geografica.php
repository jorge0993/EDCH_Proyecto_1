<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona_Geografica extends Model
{
    //
    protected $table = 'zona_geografica';
    protected $fillable = ['codigo_zona','descripcion','estatus'];
    
    public function sucursales(){
        return $this->hasMany('App\Sucursal');
    }
    public function departamentos(){
        return $this->hasMany('App\Departamento');
    }
}
