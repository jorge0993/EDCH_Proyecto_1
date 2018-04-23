<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    //
    protected $table = 'colaboradores';
    protected $fillable = ['n_colaborador', 'apellido_p','apellido_m','nombres','papas','credencial','email','celular','telefonoempresa','ext','sexo','id_sucursal','visa','id_nacionalidad','fecha_ingreso','fecha_nacimiento','id_nivel_estudio',
    'id_carrera','certificado','NIMSS','CURP','RFC','tipo_sangre','donante','id_area','id_jerarquia','id_puesto','jefe_inmediato','foto','estado','fecha_baja','tipo_empleado','licencia','vigencia_licencia','tarjeta_coorp','carro','n_colaboradorlider',
    'colaborador_politicas','admin_docs','colaborador_codigo_etica','id_departamento','cel_empresa','baja_motivo','baja_comentario','txt_celular_empresa','txt_mail_personal','id_micronegocio','id_ciudad_estancia','id_integracion','id_aprobador','id_aprobador_aux','id_aprobador_disp','edo_civil','recontratacion'];

    public function usuarios(){
        return $this->hasMany('App\Usuario');
    }
    public function sucursal(){
        return $this->belongsTo('App\Sucursal','id_sucursal');
    }
    public function nacionalidad(){
        return $this->belongsTo('App\Nacionalidad','id_nacionalidad');
    }
    public function nivel_estudio(){
        return $this->belongsTo('App\Nivel_Estudio','id_nivel_estudio');
    }
    public function carrera(){
        return $this->belongsTo('App\Carrera','id_carrera');
    }
    public function area(){
        return $this->belongsTo('App\Area','id_area');
    }
    public function jerarquia(){
        return $this->belongsTo('App\Jerarquia','id_jerarquia');
    }
    public function puesto(){
        return $this->belongsTo('App\Puesto','id_puesto');
    }
    public function jefeInmediato(){
        return $this->belongsTo('App\Colaborador','jefe_inmediato');
    }
    public function tipoEmpleado(){
        return $this->belongsTo('App\Tipo_Empleado','tipo_empleado');
    }
    public function departamento(){
        return $this->belongsTo('App\Departamento','id_departamento');
    }
    public function micronegocio(){
        return $this->belongsTo('App\Micronegocio','id_micronegocio');
    }
    public function aprobador(){
        return $this->belongsTo('App\Usuario','id_aprobador');
    }
    public function aprobador_aux(){
        return $this->belongsTo('App\Usuario','id_aprobador_aux');
    }
    public function aprobador_disp(){
        return $this->belongsTo('App\Usuario','id_aprobador_disp');
    }
}
