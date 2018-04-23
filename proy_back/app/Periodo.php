<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    //
    protected $fillable = ['periodo'];
    
    public function asignaciones(){
        return $this->hasMany('App\Asignacion');
    }
}
