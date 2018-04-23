<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Empleado extends Model
{
    //
    protected $table = 'tipos_empleados';
    protected $fillable = ['tipo_empleado_desc'];
    
    public function colaboradores(){
        return $this->hasMany('App\Colaborador');
    }
}
