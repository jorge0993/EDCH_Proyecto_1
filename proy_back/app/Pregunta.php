<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    //
    protected $table = 'preguntas';
    protected $fillable = ['pregunta','orden_preg','id_categoria'];
    
    public function respuestas(){
        return $this->hasMany('App\Respuesta');
    }
    public function categoria(){
        return $this->belongsTo('App\Region','id_categoria');
    }
}
