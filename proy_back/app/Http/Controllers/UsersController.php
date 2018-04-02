<?php

namespace App\Http\Controllers;
use Response;
use App\Cliente;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('jwt.auth');
}
    //Mostrar con paginacion
    public function index(Request $request){
        $search_term = $request->input('search');
        $limit = $request->input('limit')?$request->input('limit'):5;

        if ($search_term)
        {
            $usuarios = Usuario::orderBy('id', 'DESC')->where('nombreusuario', 'LIKE', "%$search_term%")->select('id', 'nombreusuario', 'user')->paginate($limit); 

            $usuarios->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $usuarios = Usuario::orderBy('id', 'DESC')->select('id', 'nombreusuario', 'user')->paginate($limit);

            $usuarios->appends(array(            
                'limit' => $limit
            ));
        }
    return Response::json($this->transformCollection($usuarios), 200);
    }
    //Mostrar por id
    public function show($id){
        $usuario = Usuario::where('id','=',$id);

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

        if(! $request->nombreusuario or ! $request->user or ! $request->correo or ! $request->telefono or ! $request->foto or ! $request->idempresa or ! $request->password or ! $request->status or ! $request->activo or ! $request->tipousuario){
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
        if(!$request->nombreusuario or ! $request->user or ! $request->correo or ! $request->telefono or ! $request->foto or ! $request->idempresa or ! $request->password or ! $request->status or ! $request->activo or ! $request->tipousuario){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        
        $usuario = Usuario::find($id);
        $usuario->nombreusuario = $request->nombreusuario;
        $usuario->user = $request->user;
        $usuario->password = $request->password;
        $usuario->correo = $request->correo;
        $usuario->telefono = $request->telefono;
        $usuario->idempresa = $request->idempresa;
        $usuario->foto = $request->foto;
        $usuario->status = $request->status;
        $usuario->activo = $request->activo;
        $usuario->tipousuario = $request->tipousuario;
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
        return [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombreusuario'],
                'user' => $usuario['user'],
        ];
    }
}
