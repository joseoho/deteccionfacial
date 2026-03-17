
                                       @if (session()->has('noexiste'))
                        					<div class="alert alert-danger" role="alert">No hay registros disponibles para su consulta</div>
                        					{{session('noexiste')}}
                    					@endif                                     
                                        <div class="col-sm-5">
<label for="nombre"><strong>Empleado</strong></label>
	<select name="empleado_id" id="empleado_id" class="form-control form-control-lg">
                <option>--- Seleccione uno ---</option>
                @foreach ($empleados as $empleado)
    	        <option value="{{ $empleado->cinumber }}">{{ $empleado->name }}</option>
                @endforeach
    </select>
</div>
<div class="col-sm-5">
            <label for="codigo"><strong>Fecha Inicio</strong></label>
                <input class="form-control" type="date" value="{{old('fecha_ini')}}" name="fecha_ini" id="fecha_ini" required>      
            </div>
            <div class="col-sm-5">
            <label for="codigo"><strong>Fecha Fin</strong></label>
                <input class="form-control" type="date" value="{{old('fecha_fin')}}" name="fecha_fin" id="fecha_fin" required> 
</div>

@section('scripts')
		<script type="text/javascript">
		$(document).ready(function() {
			$('#empleado_id').select2();
		});
	</script>
	@endsection