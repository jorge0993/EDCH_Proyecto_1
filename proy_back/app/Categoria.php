<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    protected $fillable = ['categoria', 'orden_cat'];
    
    public function encuestas(){
        return $this->belongsToMany('App\Encuesta', 'Encuesta_Categoria', 'id_categoria', 'id_encuesta');
    }
}
