<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumnosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alumnos=Alumnos::orderBy('nombre')->paginate(5);
        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alumnos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required'],
            'apellidos' => ['required'],
            'email' => ['required', 'unique:alumnos,email'],
            'telefono' => ['nullable']
        ]);

        $alumno = new Alumnos();
        $alumno->nombre=ucwords($request->nombre);
        $alumno->apellidos=ucwords($request->apellidos);
        $alumno->email=$request->email;

        if($request->has('telefono')) $alumno->telefono=$request->telefono;


        if($request->has('foto')){

            $request->validate(['foto'=>['image']]);

            $fileImagen=$request->file('foto');
            $nombre="img/alumnos".uniqid()."_".$fileImagen->getClientOriginalName();
            Storage::Disk("public")->put($nombre, \File::get($fileImagen));
            $alumno->foto="storage/".$nombre;
        }

        $alumno->save();
        return redirect()->route('alumnos.index')->with('mensaje', "Alumno Guardado");


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function show(Alumnos $alumnos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function edit(Alumnos $alumno)
    {
        return view('alumnos.edit', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alumnos $alumno)
    {
        $request->validate([
            'nombre' => ['required'],
            'apellidos' => ['required'],
            'email' => ['required', 'unique:alumnos,email'],
            'telefono' => ['nullable']
        ]);

        $alumno->update([
            'nombre'=>ucwords($request->nombre),
            'apellidos'=>ucwords($request->apellidos),
            'email'=>$request->email,
            'telefono'=>$request->telefono
        ]);

        if($request->has('foto')){

            $request->validate(['foto'=>['image']]);

            $fileImagen=$request->file('foto');
            $nombre="img/alumnos".uniqid()."_".$fileImagen->getClientOriginalName();

            if(basename($alumno->foto)!="default.png"){
                unlink($alumno->foto);
            }

            Storage::Disk("public")->put($nombre, \File::get($fileImagen));
            $alumno->update(['foto'=>"storage/".$nombre]);
        }
        $alumno->save();
        return redirect()->route('alumnos.index')->with('mensaje', "Alumno Actualizado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumnos $alumno)
    {
        $foto = basename($alumno->foto);
        if($foto!='default.png'){
            unlink($alumno->foto);
        }

        $alumno->delete();
        return redirect()->route('alumnos.index')->with("mensaje", "Alumno borrado correctamente.");
    }
}
