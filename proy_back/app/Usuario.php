<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Usuario;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Usuario extends Model implements Authenticatable
{
    use AuthenticableTrait;
    
    protected $table = 'usuarios';
    protected $fillable = ['user', 'password','id_colaborador','activo','tipo'];
    
    public function colaborador(){
        return $this->belongsTo('App\Colaborador','id_colaborador');
    }
    public function asignasiones(){
        return $this->hasMany('App\Asignacion');
    }
}
