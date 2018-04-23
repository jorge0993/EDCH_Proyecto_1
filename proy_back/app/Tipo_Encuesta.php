<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Encuesta extends Model
{
    //
    protected $fillable = ['tipo'];
    
    public function encuestas(){
        return $this->hasMany('App\Encuesta');
    }
}
