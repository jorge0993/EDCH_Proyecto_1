<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = ['codigo_departamento', 'departamento_desc','departamento_id_colaborador','id_zona','departamento_estado'];
    
    public function colaboradores(){
        return $this->hasMany('App\Colaborador');
    }
    public function zona(){
        return $this->belongsTo('App\Zona_Geografica','id_zona');
    }
}
