<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jerarquia extends Model
{
    //
    protected $table = 'jerarquias';
    protected $fillable = ['jerarquia', 'descripcion','estado'];
    
    public function colaboradores(){
        return $this->hasMany('App\Colaborador');
    }
}
