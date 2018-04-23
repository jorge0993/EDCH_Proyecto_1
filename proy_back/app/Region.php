<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
    protected $fillable = ['region'];
    
    public function sucursales(){
        return $this->hasMany('App\Sucursal');
    }
    public function micronegocios(){
        return $this->hasMany('App\Micronegocio');
    }

}
