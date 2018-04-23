<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escala extends Model
{
    //
    protected $table = 'escalas';
    protected $fillable = ['escala', 'base'];
    
    public function encuestas(){
        return $this->hasMany('App\Encuesta');
    }
}
