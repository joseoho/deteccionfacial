@extends('layouts.templates')
@section('title', 'Editar Cliente')
@section('content')
	<div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Editar Cliente {{$empleado->name}}
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Pagina Principal</a></li>
                <li class="breadcrumb-item"><a href="{{ route('Empleado.index') }}">Empleado</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
              </ol>
            </nav>
          </div>
          <div class="card">
            <div class="card-body">
              {{-- <h4 class="card-title">Categorías</h4> --}}

              <div class="row">
                  <div class="col-12">
                  <form action="/Empleado/{{$empleado->id}}" method="POST">    
                    @csrf
                    @method('PATCH')   
                      
                            <div class="form-group">
                              <label for="cedula"><strong>Cedula</strong></label>
                              <input type="text" value= "{{$empleado->cinumber}}" name="cedula" id="cedula" class="form-control" placeholder="Ingrese una cedula" required>
                            </div>
                            <div class="form-group">
                              <label for="nombre"><strong>Nombre</strong></label>
                              <input type="text" value= "{{$empleado->name}}" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre" autofocus required>
                            </div>
                            <div class="form-group">
                              <label for="role"><strong>ROLE</strong></label>
                              <input type="text" value= "{{$empleado->role}}" name="role" id="role" class="form-control" placeholder="Ingrese una role" required>
                            </div>
                            <div class="form-group">
                              <label for="nota"><strong>Nota</strong></label>
                              <input type="text" value= "{{$empleado->note}}" name="nota" id="nota" class="form-control" placeholder="Ingrese una nota" required>
                            </div>


	                     <div class="form-group mr-2">
      								    <a href="{{ route('Empleado.index') }}" class="btn btn-light">Regresar</a>
      								    <button type="submit" class="btn btn-primary">Actualizar</button>
      							   </div>
      						  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection