<?php

namespace App\Http\Controllers;
use App\Carrera;
use Response;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    //
    public function index(Request $request){
        $search_term = $request->input('search');
        $limit = $request->input('limit')?$request->input('limit'):5;

        if ($search_term)
        {
            $carrera = Carrera::orderBy('id', 'DESC')->where('carrera', 'LIKE', "%$search_term%")->select('id','carrera','estado')->paginate($limit);

            $carrera->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $carrera = Carrera::orderBy('id', 'DESC')->select('id','carrera','estado')->paginate($limit);
                
            $carrera->appends(array(            
                'limit' => $limit
            ));
        }
    return Response::json($this->transformCollection($carrera), 200);
    }
    //Mostrar por id
    public function show($id){
        $carrera = Carrera::find($id);

        if(!$carrera){
            return Response::json([
                'error' => [
                    'message' => 'El carrera no existe'
                ]
            ], 404);
        }

         // obtener el carrera anterior
         $previous = Carrera::where('id', '<', $carrera->id)->max('id');

         // obtener el siguiente carrera
         $next = Carrera::where('id', '>', $carrera->id)->min('id');        
 
         return Response::json([
             'previous_carrera_id'=> $previous,
             'next_carrera_id'=> $next,
             'data' => $this->transform($carrera)
         ], 200);
    }
    //Crear
    public function store(Request $request)
    {

        if(! $request->carrera or ! $request->estado){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        $carrera = Carrera::create($request->all());

        return Response::json([
                'message' => 'carrera agregada',
                'data' => $this->transform($carrera)
        ]);
    }
    //Actualizar
    public function update(Request $request, $id)
    {    
        if(! $request->carrera or ! $request->estado){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        
        $carrera = Carrera::find($id);
        $carrera->carrera = $request->carrera;
        $carrera->estado = $request->estado;
        $carrera->save();

        return Response::json([
                'message' => 'carrera Actualizado'
        ]);
    }
    // Eliminar 
    public function destroy($id)
    {
        Carrera::destroy($id);
    }

    private function transformCollection($carrera){
        $carreraArray = $carrera->toArray();
        return [
            'total' => $carreraArray['total'],
            'per_page' => intval($carreraArray['per_page']),
            'current_page' => $carreraArray['current_page'],
            'last_page' => $carreraArray['last_page'],
            'next_page_url' => $carreraArray['next_page_url'],
            'prev_page_url' => $carreraArray['prev_page_url'],
            'from' => $carreraArray['from'],
            'to' =>$carreraArray['to'],
            'data' => array_map([$this, 'transform'], $carreraArray['data'])
        ];
    }
    
    private function transform($carrera){
        return $carrera;
    }
}
