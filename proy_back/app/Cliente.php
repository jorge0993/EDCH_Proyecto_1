<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;

class Cliente extends Model
{
    protected $fillable = ['nombrecliente', 'direccion','telefono','celular','user_id','idempresa','observacion','pathfile','status'];
    
    public function usuario(){
        return $this->belongsTo('App\Usuario','user_id');
    }
}
