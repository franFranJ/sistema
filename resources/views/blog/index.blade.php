@extends('layouts.app')
@section('content')
<div class="container">

    <form action="{{route('blog.index')}}" method="get">
        <div class="card mb-4">
            <div class="card-body">
                <div class="input-group">
                <input type="text" class="form-control" name="texto" 
                id="texto" placeholder="Buscar..." value="{{$texto}}">
                <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">Buscar</button>
                </span>
                </div>
            </div>
        </div>
    </form>

    @if(count($entradas)<=0)
    <?php // esto se muestra solo si no hay registros!!! ; ?>
    
    <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">No hay registros para mostrar</h5>                
            </div>
     </div>    


    @endif

     @foreach ($entradas as $entrada)

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{$entrada->titulo}}</h5>
                <p class="card-text">{{$entrada->contenido}}...
<!--                 <a href="{{route('entrada.show',
                    ['entrada'=>$entrada->id])}}"
                    class="btn btn-success">Leer más</a> -->

                    <a href=
                    "{{route('blog.show',['entrada'=>$entrada->id])}}"
                    >Leer más</a>
                </p>
                <p class="card-tex">{{\Carbon\Carbon::parse($entrada->created_at)->isoFormat('DD MMMM, YYYY - hh:mm A')}}</p>

            </div>
        </div>
     @endforeach 


   <!--      <div class="alert alert-primary" role="alert">
    A simple primary alert—check it out!
        </div> -->
    
</div>

@endsection
