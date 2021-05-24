<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->localidad);
        if(!isset($request->localidad)) $request->localidad="%";

        $localidades=Tienda::orderBy('localidad')->distinct()->get('localidad');

        $tiendas = Tienda::orderBy('nombre')
        ->localidad($request->localidad)
        ->orderBy('localidad')
        ->paginate(3);

        return view('tiendas.index', compact('tiendas', 'localidades', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tiendas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //1.- Validamos
        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:50', 'unique:tiendas,nombre'],
            'localidad' => ['required', 'string', 'min:3', 'max:90'],
            'direccion' => ['required', 'string', 'min:4', 'max:120'],
            'email' => ['required', 'string', 'min:5', 'max:60', 'unique:tiendas,email']
        ]);
        //2.- Procesar
        try {
            Tienda::create($request->all());
        } catch (\Exception $ex) {
            return redirect()->route('tiendas.index')->with("mensaje", "Error con la BBDD");
        }
        return redirect()->route('tiendas.index')->with("mensaje", "Tienda creada");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function show(Tienda $tienda)
    {
        return view('tiendas.mostrar', compact('tienda'));
        //compact('tienda') ===> ['tienda'=>$tienda];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function edit(Tienda $tienda)
    {
        return view('tiendas.edit', compact('tienda'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tienda $tienda)
    {
        //1.- Validamos
        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:50', 'unique:tiendas,nombre,'.$tienda->id],
            'localidad' => ['required', 'string', 'min:3', 'max:90'],
            'direccion' => ['required', 'string', 'min:4', 'max:120'],
            'email' => ['required', 'string', 'min:5', 'max:60', 'unique:tiendas,email,'.$tienda->id]
        ]);
        //2.- Procesar
        try {
            $tienda->update($request->all());
        } catch (\Exception $ex) {
            return redirect()->route('tiendas.index')->with("mensaje", "Error con la BBDD: ".$ex->getMessage());
        }
        return redirect()->route('tiendas.index')->with("mensaje", "Tienda Actualizada");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tienda $tienda)
    {
        try {
            $tienda->delete();
        } catch (\Exception $ex) {
            return redirect()->route('tiendas.index')->with("mensaje", "Error con la BBDD");
        }
        return redirect()->route('tiendas.index')->with("mensaje", "Tienda Borrada");
    }
}
