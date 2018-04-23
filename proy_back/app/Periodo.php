<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    //
    protected $table = 'periodos';
    protected $fillable = ['periodo'];
    
    public function asignaciones(){
        return $this->hasMany('App\Asignacion');
    }
}
