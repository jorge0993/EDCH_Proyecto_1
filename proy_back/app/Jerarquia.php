<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jerarquia extends Model
{
    //
    protected $fillable = ['jerarquia', 'descripcion','estado'];
    
    public function colaboradores(){
        return $this->hasMany('App\Colaborador');
    }
}
