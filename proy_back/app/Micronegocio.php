<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micronegocio extends Model
{
    protected $table = 'micronegocios';
    protected $fillable = ['nombre','id_region'];
    
    public function colaboradores(){
        return $this->hasMany('App\Colaborador','id_micronegocio');
    }
    public function region(){
        return $this->belongsTo('App\Region','id_region');
    }
}
