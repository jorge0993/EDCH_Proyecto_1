<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Micronegocio;
use Response;

class MicronegocioController extends Controller
{
    //
    public function index(Request $request){
        $search_term = $request->input('search');
        $limit = $request->input('limit')?$request->input('limit'):5;

        if ($search_term)
        {
            $micronegocio = Micronegocio::orderBy('id', 'DESC')->where('nombre', 'LIKE', "%$search_term%")->with(
                array('region'=>function($query){
                    $query->select('id','region');
                }))->select('id','nombre', 'id_region')->paginate($limit);

            $micronegocio->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $micronegocio = Micronegocio::orderBy('id', 'DESC')->with(
                array('region'=>function($query){
                    $query->select('id','region');
                }))->select('id','nombre', 'id_region')->paginate($limit);
            $micronegocio->appends(array(            
                'limit' => $limit
            ));
        }
    return Response::json($this->transformCollection($micronegocio), 200);
    }
    //Mostrar por id
    public function show($id){
        $micronegocio = Micronegocio::with(
            array('region'=>function($query){
                $query->select('id','region');
            }))->find($id);

        if(!$micronegocio){
            return Response::json([
                'error' => [
                    'message' => 'El micronegocio no existe'
                ]
            ], 404);
        }

         // obtener el micronegocio anterior
         $previous = Micronegocio::where('id', '<', $micronegocio->id)->max('id');

         // obtener el siguiente micronegocio
         $next = Micronegocio::where('id', '>', $micronegocio->id)->min('id');        
 
         return Response::json([
             'previous_micronegocio_id'=> $previous,
             'next_micronegocio_id'=> $next,
             'data' => $this->transform($micronegocio)
         ], 200);
    }
    //Crear
    public function store(Request $request)
    {

        if(! $request->nombre or !$request->id_region){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        $micronegocio = Micronegocio::create($request->all());

        return Response::json([
                'message' => 'micronegocio agregado',
                'data' => $this->transform($micronegocio)
        ]);
    }
    //Actualizar
    public function update(Request $request, $id)
    {    
        if(! $request->nombre or !$request->id_region){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        
        $micronegocio = Micronegocio::find($id);
        $micronegocio->nombre = $request->nombre;
        $micronegocio->id_region = $request->id_region;
        $micronegocio->save();

        return Response::json([
                'message' => 'micronegocio Actualizado'
        ]);
    }
    // Eliminar 
    public function destroy($id)
    {
        Micronegocio::destroy($id);
    }

    private function transformCollection($micronegocio){
        $micronegocioArray = $micronegocio->toArray();
        return [
            'total' => $micronegocioArray['total'],
            'per_page' => intval($micronegocioArray['per_page']),
            'current_page' => $micronegocioArray['current_page'],
            'last_page' => $micronegocioArray['last_page'],
            'next_page_url' => $micronegocioArray['next_page_url'],
            'prev_page_url' => $micronegocioArray['prev_page_url'],
            'from' => $micronegocioArray['from'],
            'to' =>$micronegocioArray['to'],
            'data' => array_map([$this, 'transform'], $micronegocioArray['data'])
        ];
    }
    
    private function transform($micronegocio){
        return $micronegocio;
    }
}
