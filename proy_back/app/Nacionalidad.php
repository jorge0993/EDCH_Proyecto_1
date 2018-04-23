<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nacionalidad extends Model
{
    //
    protected $table = 'nacionalidades';
    protected $fillable = ['nacionalidad', 'flag'];
    
    public function colaboradores(){
        return $this->hasMany('App\Colaborador');
    }
}
