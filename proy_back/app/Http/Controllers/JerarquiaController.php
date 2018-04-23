<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jerarquia;
use Response;

class JerarquiaController extends Controller
{
    //
    public function index(Request $request){
        $search_term = $request->input('search');
        $limit = $request->input('limit')?$request->input('limit'):5;

        if ($search_term)
        {
            $jerarquia = Jerarquia::orderBy('id', 'DESC')->where('jerarquia', 'LIKE', "%$search_term%")->select('id','jerarquia','descripcion','estado')->paginate($limit);

            $jerarquia->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $jerarquia = Jerarquia::orderBy('id', 'DESC')->select('id','jerarquia','descripcion','estado')->paginate($limit);
                
            $jerarquia->appends(array(            
                'limit' => $limit
            ));
        }
    return Response::json($this->transformCollection($jerarquia), 200);
    }
    //Mostrar por id
    public function show($id){
        $jerarquia = Jerarquia::find($id);

        if(!$jerarquia){
            return Response::json([
                'error' => [
                    'message' => 'la jerarquia no existe'
                ]
            ], 404);
        }

         // obtener la jerarquia anterior
         $previous = Jerarquia::where('id', '<', $jerarquia->id)->max('id');

         // obtener la siguiente jerarquia
         $next = Jerarquia::where('id', '>', $jerarquia->id)->min('id');        
 
         return Response::json([
             'previous_jerarquia_id'=> $previous,
             'next_jerarquia_id'=> $next,
             'data' => $this->transform($jerarquia)
         ], 200);
    }
    //Crear
    public function store(Request $request)
    {

        if(! $request->jerarquia or ! $request->descripcion or ! $request->estado){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        $jerarquia = Jerarquia::create($request->all());

        return Response::json([
                'message' => 'jerarquia agregada',
                'data' => $this->transform($jerarquia)
        ]);
    }
    //Actualizar
    public function update(Request $request, $id)
    {    
        if(! $request->jerarquia or ! $request->descripcion or ! $request->estado){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        
        $jerarquia = Jerarquia::find($id);
        $jerarquia->jerarquia = $request->jerarquia;
        $jerarquia->descripcion = $request->descripcion;
        $jerarquia->estado = $request->estado;
        $jerarquia->save();

        return Response::json([
                'message' => 'jerarquia Actualizado'
        ]);
    }
    // Eliminar 
    public function destroy($id)
    {
        Jerarquia::destroy($id);
    }

    private function transformCollection($jerarquia){
        $jerarquiaArray = $jerarquia->toArray();
        return [
            'total' => $jerarquiaArray['total'],
            'per_page' => intval($jerarquiaArray['per_page']),
            'current_page' => $jerarquiaArray['current_page'],
            'last_page' => $jerarquiaArray['last_page'],
            'next_page_url' => $jerarquiaArray['next_page_url'],
            'prev_page_url' => $jerarquiaArray['prev_page_url'],
            'from' => $jerarquiaArray['from'],
            'to' =>$jerarquiaArray['to'],
            'data' => array_map([$this, 'transform'], $jerarquiaArray['data'])
        ];
    }
    
    private function transform($jerarquia){
        return $jerarquia;
    }
}
