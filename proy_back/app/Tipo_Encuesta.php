<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Encuesta extends Model
{
    //
    protected $table = 'tipos_encuesta';
    protected $fillable = ['tipo'];
    
    public function encuestas(){
        return $this->hasMany('App\Encuesta');
    }
}
