<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cursada;
use Illuminate\Http\Request;

class CursadasAdminController extends Controller
{

    public function index(Request $request)
    {       
        $cursdas = [];
        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';
        $porPagina = 15;

        $query = Cursada::select('alumnos.id as alumno','cursadas.id as cursada','asignaturas.id as asignatura','cursadas.aprobada')
            -> join('asignaturas','asignaturas.id','=','cursadas.id_asignatura')
            -> join('carreras','carreras.id','=','asignaturas.id_carrera')
            -> join('alumnos','alumnos.id','=','cursadas.id_alumno');

        
        if($campo == "asignatura"){
            $query = $query->where('asignaturas.nombre','LIKE','%'.$request->filtro.'%'); 
        }
        else if($campo == "carrera"){
            $query = $query->where('carreras.nombre','LIKE','%'.$request->filtro.'%'); 
        }

        
        // if($orden == "fecha"){
        //     $query->orderByDesc('cursadas.fecha');
        // }
        if($orden == "asignatura"){
            $query->orderBy('asignaturas.nombre');
        }

        $cursadas = $query -> paginate($porPagina);
        
        //dd($mesas);
        return view('Admin.Cursadas.index',[
            'cursadas' => $cursadas, 
            'filtros'=>[
                'campo' => $campo,
                'orden' => $orden,
                'filtro' => $filtro
            ]
        ]);
    }
   
    function delete(Cursada $cursada){
        $cursada -> delete();
        return redirect()->back();
    }

    function edit(Request $request, Cursada $cursada){
        //$cursada = Cursada::where('id_asignatura',$asignatura)->where('id_alumno',$alumno)->first();
        return view('Admin.Cursadas.edit',compact('cursada'));
    }

    function update(Request $request, Cursada $cursada){
        $cursada -> update($request->except('_token','_method'));
        return redirect()->back();
    }

    function create(){
        return view();
    }

    function store(Request $request){
        Cursada::create($request->all());
        return redirect() -> back();
    }
}