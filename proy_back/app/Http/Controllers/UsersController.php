<?php

namespace App\Http\Controllers;
use Response;
use App\Colaborador;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('jwt.auth');
     }
    //Mostrar con paginacion
    public function login(Request $request){
        $usuario = Usuario::where('user',$request->user)->with(
            array('colaborador'=>function($query){
                $query->select('id','n_colaborador','apellido_p','apellido_m','nombres','email','jefe_inmediato','foto');
            }))->first();
            if(!$usuario){
                return Response::json([
                        'error' => 'El usuario no existe'
                ], 404);
            }else{
                if(!Hash::check($request->password,$usuario->password)){
                    return Response::json([
                        'error' => [
                            'message' => 'La contraseña es incorrecta'
                        ]
                    ], 404);
                }
                return Response::json([
                    'data' => $this->transform($usuario)
                ], 200);
            }
            

    }
    public function index(Request $request){
        $search_term = $request->input('search');
        $limit = $request->input('limit')?$request->input('limit'):5;

        if ($search_term)
        {
            $usuarios = Usuario::orderBy('id', 'DESC')->where('user', 'LIKE', "%$search_term%")->with(
                array('colaborador'=>function($query){
                    $query->select('id','n_colaborador','apellido_p','apellido_m','nombres','email','jefe_inmediato','foto');
                }))->select('id','user','id_colaborador')->paginate($limit);

            $usuarios->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $usuarios = Usuario::orderBy('id', 'DESC')->with(
                array('colaborador'=>function($query){
                    $query->select('id','n_colaborador','apellido_p','apellido_m','nombres','email','jefe_inmediato','foto');
                })
                )->select('id','user','id_colaborador')->paginate($limit);
                
            $usuarios->appends(array(            
                'limit' => $limit
            ));
        }
    return Response::json($this->transformCollection($usuarios), 200);
    }
    //Mostrar por id
    public function show($id){
        $usuario = Usuario::with(
            array('colaborador'=>function($query){
                $query->select('id','n_colaborador','apellido_p','apellido_m','nombres','email','jefe_inmediato','foto');
            })
            )->find($id);

        if(!$usuario){
            return Response::json([
                'error' => [
                    'message' => 'El usuario no existe'
                ]
            ], 404);
        }

         // obtener el usuario anterior
         $previous = Usuario::where('id', '<', $usuario->id)->max('id');

         // obtener el siguiente usuario
         $next = Usuario::where('id', '>', $usuario->id)->min('id');        
 
         return Response::json([
             'previous_user_id'=> $previous,
             'next_user_id'=> $next,
             'data' => $this->transform($usuario)
         ], 200);
    }
    //Crear
    public function store(Request $request)
    {

        if(! $request->user or ! $request->password or ! $request->activo or ! $request->tipo or ! $request->id_colaborador){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        $request->password= Hash::make($request->password);
        $usuario = Usuario::create($request->all());

        return Response::json([
                'message' => 'Usuario agregado',
                'data' => $this->transform($usuario)
        ]);
    }
    //Actualizar
    public function update(Request $request, $id)
    {    
        if(! $request->user or ! $request->password or ! $request->activo or ! $request->tipo){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        
        $usuario = Usuario::find($id);
        $usuario->user = $request->user;
        $usuario->password = $request->password;
        $usuario->activo = $request->activo;
        $usuario->tipo = $request->tipo;
        $usuario->save();

        return Response::json([
                'message' => 'Usuario Actualizado'
        ]);
    }
    // Eliminar 
    public function destroy($id)
    {
        Usuario::destroy($id);
    }

    private function transformCollection($usuarios){
        $usuariosArray = $usuarios->toArray();
        return [
            'total' => $usuariosArray['total'],
            'per_page' => intval($usuariosArray['per_page']),
            'current_page' => $usuariosArray['current_page'],
            'last_page' => $usuariosArray['last_page'],
            'next_page_url' => $usuariosArray['next_page_url'],
            'prev_page_url' => $usuariosArray['prev_page_url'],
            'from' => $usuariosArray['from'],
            'to' =>$usuariosArray['to'],
            'data' => array_map([$this, 'transform'], $usuariosArray['data'])
        ];
    }
    
    private function transform($usuario){
        return $usuario;
    }
}
