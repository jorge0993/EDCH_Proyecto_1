<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel_Estudio extends Model
{
    //
    protected $table = 'niveles_estudio';
    protected $fillable = ['detalle'];
    
    public function colaboradores(){
        return $this->hasMany('App\Colaborador');
    }
}
