@extends ('layouts.app')

@section ('titulo',"productos")
@section('lateral')
    @parent
    <p>Esto se agrega al sidebar</p>
@endsection
@section('contenido')
    <p>Contenido de produtco</p>
@endsection