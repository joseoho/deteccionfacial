
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
										@if (session()->has('notificacion'))
                        					<div class="alert alert-success" role="alert">Registrado</div>
                        					{{session('notificacion')}}
                    					@endif
											
										@if (session()->has('noexiste'))
                         					 <div class="alert alert-danger" role="alert">Cedula no Registrada, Verifique</div>
											  {{session('noexite')}}
                      					@endif
<div class="row">
	
		<div class="col-12 grid-margin">
			<div class="card">
				<div class="row">
				
					<div class="col-md-6">
						
						<div class="card-body">
							
								<!-- <div class="form-group"> -->
								<div class="form-group">
									<label for="empleado_id"><strong>Cedula</strong></label>
									<input type="number" name="empleado_id" id="empleado_id" class="form-control" placeholder="Ingrese numero cedula"  tabindex="0" autofocus required>
								</div>
								
								
										<form action="{{ route('IngresoEmpleado.store') }}" method="POST" name="IngresoEmpleado">
											@csrf
											<button class="btn btn-success float-right mt-4 ml-2 " id="agregar" tabindex="1" >Registar</button> 
											{{-- <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Imprimir</a> --}}
										</form>	
										
								</div>
								
					</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@section('scripts')
	
	
	@endsection
	<script>

</script>