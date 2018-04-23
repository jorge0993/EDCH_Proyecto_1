<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Area;
use Response;

class AreaController extends Controller
{
    //
    public function index(Request $request){
        $search_term = $request->input('search');
        $limit = $request->input('limit')?$request->input('limit'):5;

        if ($search_term)
        {
            $area = Area::orderBy('id', 'DESC')->where('area', 'LIKE', "%$search_term%")->select('id','area','descripcion')->paginate($limit);

            $area->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $area = Area::orderBy('id', 'DESC')->select('id','area','descripcion')->paginate($limit);
                
            $area->appends(array(            
                'limit' => $limit
            ));
        }
    return Response::json($this->transformCollection($area), 200);
    }
    //Mostrar por id
    public function show($id){
        $area = Area::find($id);

        if(!$area){
            return Response::json([
                'error' => [
                    'message' => 'El area no existe'
                ]
            ], 404);
        }

         // obtener el area anterior
         $previous = Area::where('id', '<', $area->id)->max('id');

         // obtener el siguiente area
         $next = Area::where('id', '>', $area->id)->min('id');        
 
         return Response::json([
             'previous_area_id'=> $previous,
             'next_area_id'=> $next,
             'data' => $this->transform($area)
         ], 200);
    }
    //Crear
    public function store(Request $request)
    {

        if(! $request->area or ! $request->descripcion){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        $area = Area::create($request->all());

        return Response::json([
                'message' => 'Area agregada',
                'data' => $this->transform($area)
        ]);
    }
    //Actualizar
    public function update(Request $request, $id)
    {    
        if(! $request->area or ! $request->descripcion){
            return Response::json([
                'error' => [
                    'message' => 'Favor de proporcionar los datos necesarios'
                ]
            ], 422);
        }
        
        $area = Area::find($id);
        $area->area = $request->area;
        $area->descripcion = $request->descripcion;
        $area->save();

        return Response::json([
                'message' => 'Area Actualizado'
        ]);
    }
    // Eliminar 
    public function destroy($id)
    {
        Area::destroy($id);
    }

    private function transformCollection($area){
        $areaArray = $area->toArray();
        return [
            'total' => $areaArray['total'],
            'per_page' => intval($areaArray['per_page']),
            'current_page' => $areaArray['current_page'],
            'last_page' => $areaArray['last_page'],
            'next_page_url' => $areaArray['next_page_url'],
            'prev_page_url' => $areaArray['prev_page_url'],
            'from' => $areaArray['from'],
            'to' =>$areaArray['to'],
            'data' => array_map([$this, 'transform'], $areaArray['data'])
        ];
    }
    
    private function transform($area){
        return $area;
    }
}
