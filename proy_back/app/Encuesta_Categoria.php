<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuesta_Categoria extends Model
{
    protected $table = 'encuesta_categoria';
    protected $fillable = ['id_encuesta', 'id_categoria'];

    
}
