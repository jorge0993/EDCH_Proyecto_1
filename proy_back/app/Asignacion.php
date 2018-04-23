<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';
    protected $fillable = ['id_encuesta', 'id_evaluador','fecha_asignacion','ano','id_periodo','estatus','id_asignador','id_evaluado'];
    
    public function evaluaciones(){
        return $this->hasMany('App\Evaluacion');
    }
    public function evaluador(){
        return $this->belongsTo('App\Usuario','id_evaluador');
    }
    public function periodo(){
        return $this->belongsTo('App\Periodo','id_periodo');
    }
    public function asignador(){
        return $this->belongsTo('App\Usuario','id_asignador');
    }
    public function evaluado(){
        return $this->belongsTo('App\Usuario','id_evaluado');
    }
    public function encuesta(){
        return $this->belongsTo('App\Encuesta','id_encuesta');
    }

}
