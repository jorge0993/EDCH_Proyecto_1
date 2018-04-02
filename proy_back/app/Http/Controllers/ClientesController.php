<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;
use App\Cliente;
use App\Usuario;

class ClientesController extends Controller
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
            $clientes = Cliente::orderBy('id', 'DESC')->where('nombrecliente', 'LIKE', "%$search_term%")->with(
            array('usuario'=>function($query){
                $query->select('id','nombreusuario');
            })
            )->select('id', 'nombrecliente', 'user_id')->paginate($limit); 

            $clientes->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $clientes = Cliente::orderBy('id', 'DESC')->with(
            array('usuario'=>function($query){
                $query->select('id','nombreusuario');
            })
            )->select('id', 'nombrecliente', 'user_id')->paginate($limit);

            $clientes->appends(array(            
                'limit' => $limit
            ));
        }
    return Response::json($this->transformCollection($clientes), 200);
    }
    //Mostrar por id
    public function show($id){
        $cliente = Cliente::with(
            array('usuario'=>function($query){
                $query->select('id','nombreusuario');
            })
            )->find($id);

        if(!$cliente){
            return Response::json([
                'error' => [
                    'message' => 'El cliente no existe'
                ]
            ], 404);
        }

         // obtener el cliente anterior
         $previous = Cliente::where('id', '<', $cliente->id)->max('id');

         // obtener el siguiente cliente
         $next = Cliente::where('id', '>', $cliente->id)->min('id');        
 
         return Response::json([
             'previous_cliente_id'=> $previous,
             'next_cliente_id'=> $next,
             'data' => $this->transform($cliente)
         ], 200);
    }
    //Crear
    public function store(Request $request)
    {

        if(! $request->nombrecliente or ! $request->user_id or ! $request->direccion or ! $request->telefono or ! $request->celular or ! $request->idempresa or ! $request->observacion or ! $request->status){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        $cliente = Cliente::create($request->all());

        return Response::json([
                'message' => 'Cliente agregado',
                'data' => $this->transform($cliente)
        ]);
    }
    //Actualizar
    public function update(Request $request, $id)
    {    
        if(! $request->nombrecliente or ! $request->user_id or ! $request->direccion or ! $request->telefono or ! $request->celular or ! $request->idempresa or ! $request->observacion or ! $request->status){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        
        $cliente = Cliente::find($id);
        $cliente->nombrecliente = $request->nombrecliente;
        $cliente->user_id = $request->user_id;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->celular = $request->celular;
        $cliente->idempresa = $request->idempresa;
        $cliente->observacion = $request->observacion;
        $cliente->status = $request->status;
            if($request->pathfile){
                $cliente->pathfile = $request->pathfile;
            }
        $cliente->save();

        return Response::json([
                'message' => 'Cliente Actualizado'
        ]);
    }
    // Eliminar 
    public function destroy($id)
    {
        Cliente::destroy($id);
    }
    private function transformCollection($clientes){
        $clientesArray = $clientes->toArray();
        return [
            'total' => $clientesArray['total'],
            'per_page' => intval($clientesArray['per_page']),
            'current_page' => $clientesArray['current_page'],
            'last_page' => $clientesArray['last_page'],
            'next_page_url' => $clientesArray['next_page_url'],
            'prev_page_url' => $clientesArray['prev_page_url'],
            'from' => $clientesArray['from'],
            'to' =>$clientesArray['to'],
            'data' => array_map([$this, 'transform'], $clientesArray['data'])
        ];
    }
    
    private function transform($cliente){
        return [
                'cliente_id' => $cliente['id'],
                'cliente' => $cliente['nombrecliente'],
                'created_by' => $cliente['usuario']['nombreusuario']
        ];
    }

}
