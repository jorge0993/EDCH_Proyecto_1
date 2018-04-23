<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    //
    protected $table = 'respuestas';
    protected $fillable = ['respuesta','comentario','id_evaluacion','id_pregunta'];
    
    public function evaluacion(){
        return $this->belongsTo('App\Evaluacion','id_evaluacion');
    }
    public function pregunta(){
        return $this->belongsTo('App\Pregunta','id_pregunta');
    }
}
