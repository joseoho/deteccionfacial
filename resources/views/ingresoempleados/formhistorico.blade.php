@extends('layouts.templates')
@section('title', 'HISTORICO EMPLEADOS')
@section('content') 
@foreach ($empleados as $empleado)
@endforeach
<div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              HISTORICO EMPLEADOS
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('Empleado.index') }}">Empleados</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear Nuevo</li>
              </ol>
            </nav>
          </div>
        
<form action="{{ route('IngresoEmpleado.historico') }}" method="POST" file="true" name="showEmpleado" enctype="multipart/form-data">
@csrf
<div class="row">
	
		<div class="col-12 grid-margin">
			<div class="card">
				<div class="row">
				
					<div class="col-md-6">
						
						<div class="card-body">
							
                        <div class="form-group">
                            <label for="nombre"><strong>Seleccione Empleado</strong></label>
                            <select name="empleado_id" id="empleado_id" class="form-control form-control-lg">
                                        <option>--- Seleccione uno ---</option>
                                        @foreach ($empleados as $empleado)
                                        <option value="{{ $empleado->cinumber }}">{{ $empleado->name }}</option>
                                        @endforeach
                            </select>
                        </div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
										
			<button class="btn btn-success float-right mt-4 ml-2 " id="agregar" onclick="" tabindex="1" >Ver Historico</button> 
		
</form>	
</div>
@endsection

@section('scripts')
		<script type="text/javascript">
		$(document).ready(function() {
			$('#empleado_id').select2();
		});
	</script>
    @endsection