<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Escala;
use Response;

class EscalaController extends Controller
{
    //
    public function index(Request $request){
        $search_term = $request->input('search');
        $limit = $request->input('limit')?$request->input('limit'):5;

        if ($search_term)
        {
            $escala = Escala::orderBy('id', 'DESC')->where('escala', 'LIKE', "%$search_term%")->select('id','escala','base')->paginate($limit);

            $escala->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $escala = Escala::orderBy('id', 'DESC')->select('id','escala','base')->paginate($limit);
                
            $escala->appends(array(            
                'limit' => $limit
            ));
        }
    return Response::json($this->transformCollection($escala), 200);
    }
    //Mostrar por id
    public function show($id){
        $escala = Escala::find($id);

        if(!$escala){
            return Response::json([
                'error' => [
                    'message' => 'La escala no existe'
                ]
            ], 404);
        }

         // obtener la escala anterior
         $previous = Escala::where('id', '<', $escala->id)->max('id');

         // obtener la siguiente escala
         $next = Escala::where('id', '>', $escala->id)->min('id');        
 
         return Response::json([
             'previous_escala_id'=> $previous,
             'next_escala_id'=> $next,
             'data' => $this->transform($escala)
         ], 200);
    }
    //Crear
    public function store(Request $request)
    {

        if(! $request->escala or ! $request->base){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        $escala = Escala::create($request->all());

        return Response::json([
                'message' => 'escala agregada',
                'data' => $this->transform($escala)
        ]);
    }
    //Actualizar
    public function update(Request $request, $id)
    {    
        if(! $request->escala or ! $request->base){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        
        $escala = Escala::find($id);
        $escala->escala = $request->escala;
        $escala->base = $request->base;
        $escala->save();

        return Response::json([
                'message' => 'escala Actualizada'
        ]);
    }
    // Eliminar 
    public function destroy($id)
    {
        Escala::destroy($id);
    }

    private function transformCollection($escala){
        $escalaArray = $escala->toArray();
        return [
            'total' => $escalaArray['total'],
            'per_page' => intval($escalaArray['per_page']),
            'current_page' => $escalaArray['current_page'],
            'last_page' => $escalaArray['last_page'],
            'next_page_url' => $escalaArray['next_page_url'],
            'prev_page_url' => $escalaArray['prev_page_url'],
            'from' => $escalaArray['from'],
            'to' =>$escalaArray['to'],
            'data' => array_map([$this, 'transform'], $escalaArray['data'])
        ];
    }
    
    private function transform($escala){
        return $escala;
    }
}
