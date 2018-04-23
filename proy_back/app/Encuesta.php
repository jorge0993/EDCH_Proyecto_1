<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $fillable = ['encuesta', 'id_escala','id_tipo'];
    
    public function categorias(){
        return $this->belongsToMany('App\Categoria', 'Encuesta_Categoria', 'id_encuesta', 'id_categoria');
    }
    
}
