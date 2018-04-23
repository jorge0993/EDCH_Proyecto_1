<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    //
    protected $fillable = ['sucursal','direccion','tel1','tel2','id_zona','id_region','cot'];
    
    public function colaboradores(){
        return $this->hasMany('App\Colaborador');
    }
    public function region(){
        return $this->belongsTo('App\Region','id_region');
    }
    public function zona(){
        return $this->belongsTo('App\Zona_Geografica','id_zona');
    }
}
