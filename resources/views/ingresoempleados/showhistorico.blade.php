@extends('layouts.templates')
@section('title', 'Lista de Empleados')
@section('styles')
  <style type="text/css">
    .unstyled-button{
      border: none;
      padding: 0;
      background: none;
    }
  </style>
@endsection
@section('content')
	<div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
            Lista de Empleados
            </h3>
            
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Empleado</li>
              </ol>
            </nav>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h3>Empleados</h3>
                </div>
                <div>
                 {{-- <a href="{{route('DESCARGARPDF')}}" class="btn btn-success">
                    <i class="fas fa-download"></i>
                  </a>
                   <a href="{{ route('Empleado.create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i></a > --}}
                </div>
              </div><br>

              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>ID</th>
                            <th>CEDULA</th>
                            <th>FOTO</th>
                            <th>ENTRADA/SALIDA</th>
                            
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($marcaingresos as $ingreso)
                        	<tr>
                            <td scope="row">{{ $empleado->id }}</td>
                            {{-- <td>
                               <a href="{{ route('Historicos.index', $ingreso) }}">{{ $ingreso->cinumber }}</a> 
                              
                            </td> --}}
                            <td>{{ $ingreso->cinumber }}</td>
                            <td>{{ $ingreso->photourl }}</td>
                            <td>{{ $ingreso->timestamp }}</td>
                           
                            <td>
                            <form action="{{route('Historicos.destroy',$ingreso->id)}}" method="POST">    <a href="{{ route('Historicos.edit', $ingreso) }}" title="Editar" class="jsgrid-button jsgrid-edit-button">
                            @method('DELETE')
                                            @csrf 
                              <a href="{{ route('Historicos.edit', $ingreso) }}" title="Editar" class="jsgrid-button jsgrid-edit-button">
                                   <i class="far fa-edit"></i>
                                 </a>
                                 <button title="Eliminar" class="jsgrid-button jsgrid-delete-button unstyled-button">
                                   <i class="far fa-trash-alt" type="submit"></i>
                                 </button>
                              </form>
                            </td>
                        </tr>
                        @endforeach
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
 @endsection
@section('scripts')
	<script src="{{asset ('assets/js/data-table.js')}}"></script>
@endsection 