<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Comentario;
use Illuminate\Http\Request;
use App\Http\Requests\EntradaFormRequest;
use App\Http\Requests\ComentarioFormRequest;
use Illuminate\Support\Facades\DB;
use Auth;
// use Validator;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $entradas = DB::table('entradas')
            ->select('id', 'titulo', 'created_at', \DB::raw('SUBSTRING(contenido,1,200) as contenido'))
            ->where('titulo', 'LIKE', '%' . $texto . '%')
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();
        return view('entrada.index', compact('entradas', 'texto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('entrada.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntradaFormRequest $request)
    {
        /*         $validator = Validator::make($request->all(),[
            'titulo'=>'required|min:5|max:70',
            'contenido'=>'required|min:5|max:255'
        ]);

        if($validator->fails()){
            return redirect()
            ->route('entrada.create')
            ->withErrors($validator)
            ->withInput()
            ;
        } */

        $entrada = new Entrada;
        $entrada->titulo = $request->input('titulo');
        $entrada->contenido = $request->input('contenido');
        $entrada->user_id = Auth::user()->id;
        // $request->user()->id;
        $entrada->save();
        return redirect()->route('entrada.index');

        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function show(Entrada $entrada)
    {
        $comentarios = DB::table('comentarios')
            ->join('users', 'comentarios.user_id', '=', 'users.id')
            ->where('comentarios.entrada_id', '=', $entrada->id)
            ->select('users.email', 'users.name', 'comentarios.contenido')
            ->orderBy('comentarios.id', 'desc')
            ->get();

        // dd($comentarios);
        return view('entrada.show', compact('entrada', 'comentarios'));
    }


    public function comentarioGuardar(ComentarioFormRequest $request)
    {
        $comentario = new Comentario();
        $comentario->contenido = $request->input('contenido');
        $comentario->entrada_id = $request->input('entrada_id');
        $comentario->user_id = \Auth::user()->id;
        $comentario->save();
            return redirect()
            ->route('entrada.show', ['entrada' => $request->input('entrada_id')])
            ->with('mensaje', 'Comentario registrado.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function edit(Entrada $entrada)
    {
        return view('entrada.edit', compact('entrada'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function update(EntradaFormRequest $request, Entrada $entrada)
    {
        if(Auth::user()->cant('update',$entrada)){
            return redirect()->route('entrada.index')
            ->with('mensaje','No tienes permisos para realizar esta acción');

        }

        $entrada->titulo = $request->input('titulo');
        $entrada->contenido = $request->input('contenido');
        $entrada->save();
        return redirect()
            ->route('entrada.edit', ['entrada' => $entrada])
            ->with('mensaje', 'Entrada actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entrada $entrada)
    {

        if(Auth::user()->cant('delete',$entrada)){
            return redirect()->route('entrada.index')
            ->with('mensaje','No tienes permisos para realizar esta acción');

        }

        $this->authorize('delete',$entrada);
        $entrada->delete();
        return redirect()->route('entrada.index');
    }
}
