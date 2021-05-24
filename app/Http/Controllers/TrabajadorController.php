<?php

namespace App\Http\Controllers;

use App\Models\{Trabajador, Tienda};
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $apellidos['%']="Todos";
        $apellidos[1]="A~F";
        $apellidos[2]="G~M";
        $apellidos[3]="N~T";
        $apellidos[4]="U~Z";

        if(!isset($request->tienda)) $request->tienda="%";
        $tiendas=Tienda::orderBy('nombre')->get();
        $trabajadores=Trabajador::orderBy('apellidos')
        ->tienda($request->tienda)
        ->paginate(5);
        return view('trabajadores.index', compact('apellidos', 'trabajadores', 'tiendas', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $misTiendas=Tienda::getArrayIdNombre();
        //dd($misTiendas);
        return view('trabajadores.create', compact('misTiendas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //1.- Validamos los datos
        $request->validate([
            'nombre'=>['required', 'string', 'min:4', 'max:35'],
            'apellidos'=>['required', 'string', 'min:8', 'max:80'],
            'email'=>['required', 'string', 'unique:trabajadors,email'],
            'tienda_id'=>['required']

        ]);
        //2.- procesamos para hacer el insert
        try{
            Trabajador::create($request->all());
        }catch(\Exception $ex){
            return redirect()->route('trabajadores.index')->with("mensaje", "Error !!!");
        }
        return redirect()->route('trabajadores.index')->with("mensaje", "Trabajador Guardado");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function show(Trabajador $trabajadore)
    {
        return view('trabajadores.mostrar', compact('trabajadore'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function edit(Trabajador $trabajadore)
    {
        $misTiendas=Tienda::getArrayIdNombre();
        return view('trabajadores.edit', compact('trabajadore', 'misTiendas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trabajador $trabajadore)
    {
         //1.- Validamos los datos
         $request->validate([
            'nombre'=>['required', 'string', 'min:4', 'max:35'],
            'apellidos'=>['required', 'string', 'min:8', 'max:80'],
            'email'=>['required', 'string', 'unique:trabajadors,email,'.$trabajadore->id],
            'tienda_id'=>['required']

        ]);
        //2.- procesamos para hacer el insert
        try{
            $trabajadore->update($request->all());
        }catch(\Exception $ex){
            return redirect()->route('trabajadores.index')->with("mensaje", "Error !!!");
        }
        return redirect()->route('trabajadores.index')->with("mensaje", "Trabajador Actualizado");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trabajador $trabajadore)
    {
        try {
            $trabajadore->delete();
        } catch (\Exception $ex) {
            return redirect()->route('trabajadores.index')->with("mensaje", "Error con la BBDD");
        }
        return redirect()->route('trabajadores.index')->with("mensaje", "Trabajador eliminado");
    }

}
