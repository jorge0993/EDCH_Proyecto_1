<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Usuario;

class Usuario extends Model
{
    protected $fillable = ['nombreusuario', 'correo','telefono','foto','user','password','idempresa','activo','status','tipousuario'];
    
    public function clientes(){
        return $this->hasMany('App\Cliente');
    }
}
