<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $fillable = ['id_asignacion','fecha_elaboracion'];
    
    public function respuestas(){
        return $this->hasMany('App\Respuesta');
    }
    public function asignacion(){
        return $this->belongsTo('App\Asignacion','id_asignacion');
    }
    
}
