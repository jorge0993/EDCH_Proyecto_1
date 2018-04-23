<?php

namespace App\Http\Controllers;
use App\Departamento;
use Response;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    //
    public function index(Request $request){
        $search_term = $request->input('search');
        $limit = $request->input('limit')?$request->input('limit'):5;

        if ($search_term)
        {
            $departamento = Departamento::orderBy('id', 'DESC')->where('codigo_departamento', 'LIKE', "%$search_term%")->with(
                array('zona'=>function($query){
                    $query->select('id','codigo_zona','descripcion','estatus');
                }))->select('id','codigo_departamento', 'departamento_desc','departamento_id_colaborador','id_zona','departamento_estado')->paginate($limit);

            $departamento->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $departamento = Departamento::orderBy('id', 'DESC')->with(
                array('zona'=>function($query){
                    $query->select('id','codigo_zona','descripcion','estatus');
                }))->select('id','codigo_departamento', 'departamento_desc','departamento_id_colaborador','id_zona','departamento_estado')->paginate($limit);
                
            $departamento->appends(array(            
                'limit' => $limit
            ));
        }
    return Response::json($this->transformCollection($departamento), 200);
    }
    //Mostrar por id
    public function show($id){
        $departamento = Departamento::with(
            array('zona'=>function($query){
                $query->select('id','codigo_zona','descripcion','estatus');
            })
            )->find($id);

        if(!$departamento){
            return Response::json([
                'error' => [
                    'message' => 'El departamento no existe'
                ]
            ], 404);
        }

         // obtener el departamento anterior
         $previous = Departamento::where('id', '<', $departamento->id)->max('id');

         // obtener el siguiente departamento
         $next = Departamento::where('id', '>', $departamento->id)->min('id');        
 
         return Response::json([
             'previous_departamento_id'=> $previous,
             'next_departamento_id'=> $next,
             'data' => $this->transform($departamento)
         ], 200);
    }
    //Crear
    public function store(Request $request)
    {

        if(! $request->codigo_departamento or !$request->departamento_desc or !$request->id_zona or !$request->departamento_estado){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        $departamento = Departamento::create($request->all());

        return Response::json([
                'message' => 'departamento agregado',
                'data' => $this->transform($departamento)
        ]);
    }
    //Actualizar
    public function update(Request $request, $id)
    {    
        if(! $request->codigo_departamento or !$request->departamento_desc or !$request->id_zona or !$request->departamento_estado){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        
        $departamento = Departamento::find($id);
        $departamento->codigo_departamento = $request->codigo_departamento;
        $departamento->departamento_desc = $request->departamento_desc;
        $departamento->departamento_id_colaborador = $request->departamento_id_colaborador?:0;
        $departamento->id_zona = $request->id_zona;
        $departamento->departamento_estado = $request->departamento_estado;
        $departamento->save();

        return Response::json([
                'message' => 'departamento Actualizado'
        ]);
    }
    // Eliminar 
    public function destroy($id)
    {
        Departamento::destroy($id);
    }

    private function transformCollection($departamento){
        $departamentoArray = $departamento->toArray();
        return [
            'total' => $departamentoArray['total'],
            'per_page' => intval($departamentoArray['per_page']),
            'current_page' => $departamentoArray['current_page'],
            'last_page' => $departamentoArray['last_page'],
            'next_page_url' => $departamentoArray['next_page_url'],
            'prev_page_url' => $departamentoArray['prev_page_url'],
            'from' => $departamentoArray['from'],
            'to' =>$departamentoArray['to'],
            'data' => array_map([$this, 'transform'], $departamentoArray['data'])
        ];
    }
    
    private function transform($departamento){
        return $departamento;
    }
}
