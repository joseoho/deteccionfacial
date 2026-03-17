			@if($errors->any())
			@endif
					@if (session()->has('duplicado'))
                      <div class="alert alert-warning" role="alert">Empleado ya se encuentra Registrado</div>
                      {{session('duplicado')}}
					@endif   

@if ($errors->has('cedula'))
    <span class="alert alert-warning">
    <span>{{$errors->first('cedula')}}</span>
    </span>
@endif
<div class="form-group">
	<label for="cedula"><strong>Cedula</strong></label>
	<input type="text" name="cedula" id="cedula" class="form-control" placeholder="Ingrese una cedula">
</div>
@if ($errors->has('nombre'))
    <span class="alert alert-warning">
    <span>{{$errors->first('nombre')}}</span>
    </span>
@endif
<div class="form-group">
	<label for="nombre"><strong>Nombre</strong></label>
	<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre" autofocus >
</div>
@if ($errors->has('role'))
    <span class="alert alert-warning">
    <span>{{$errors->first('role')}}</span>
    </span>
@endif
<div class="form-group">
	<label for="role"><strong>ROLE</strong></label>
	<input type="text" name="role" id="role" class="form-control" placeholder="Ingrese una role" >
</div>
@if ($errors->has('nota'))
    <span class="alert alert-warning">
    <span>{{$errors->first('nota')}}</span>
    </span>
@endif
<div class="form-group">
	<label for="nota"><strong>Nota</strong></label>
	<input type="text" name="nota" id="nota" class="form-control" placeholder="Ingrese una nota" >
</div>
<div class="form-group">
		<label><strong>Status</strong></label>
		<select id="status" name="status" class="form-control text-center">
		<option value="Elegir">-- Selecione --</option>
		<option value="ACTIVO">ACTIVO</option>
		<option value="VACACIONES">VACACIONES</option>
		<option value="REPOSO">REPOSO</option>
		</select>
	</div>

	<div class="form-group">
		<label><strong>Foto de Referencia (Para Reconocimiento Facial)</strong></label>
		<div class="row">
			<div class="col-md-6">
				<div id="employee_video_wrap" style="position: relative; width: 100%; max-width: 400px;">
					<video id="employee_video_frame" width="100%" autoplay playsinline muted style="border: 2px solid #ddd; border-radius: 8px;"></video>
					<canvas id="employee_canvas_frame" style="display: none;"></canvas>
				</div>
				<br>
				<button type="button" id="employee_snap_frame" class="btn btn-info">
					<i class="fas fa-camera"></i> Capturar Foto
				</button>
				<button type="button" id="employee_clear_frame" class="btn btn-secondary" style="display: none;">
					<i class="fas fa-redo"></i> Tomar Otra
				</button>
				<input type="hidden" name="reference_photo" id="reference_photo" value="">
			</div>
			<div class="col-md-6">
				<div id="employee_preview" style="display: none;">
					<img id="employee_preview_img" src="" alt="Preview" style="max-width: 100%; border: 2px solid #28a745; border-radius: 8px;">
					<p class="text-success mt-2"><i class="fas fa-check-circle"></i> Foto capturada</p>
				</div>
			</div>
		</div>
		<small class="form-text text-muted">Capture una foto clara del rostro del empleado para el reconocimiento facial</small>
	</div>

	<script>
		// Inicializar webcam para empleados
		const employeeVideoFrame = document.getElementById('employee_video_frame');
		const employeeCanvasFrame = document.getElementById('employee_canvas_frame');
		const employeeSnapFrame = document.getElementById('employee_snap_frame');
		const employeeClearFrame = document.getElementById('employee_clear_frame');
		const employeePreview = document.getElementById('employee_preview');
		const employeePreviewImg = document.getElementById('employee_preview_img');
		const referencePhotoInput = document.getElementById('reference_photo');

		let employeeStream = null;

		// Inicializar webcam
		async function initEmployeeWebcam() {
			try {
				employeeStream = await navigator.mediaDevices.getUserMedia({
					audio: false,
					video: { width: 640, height: 480 }
				});
				employeeVideoFrame.srcObject = employeeStream;
			} catch (e) {
				console.error('Error accessing webcam:', e);
				alert('No se pudo acceder a la cámara. Por favor, permita el acceso a la cámara.');
			}
		}

		// Capturar foto
		employeeSnapFrame.addEventListener('click', function() {
			const context = employeeCanvasFrame.getContext('2d');
			employeeCanvasFrame.width = employeeVideoFrame.videoWidth;
			employeeCanvasFrame.height = employeeVideoFrame.videoHeight;
			context.drawImage(employeeVideoFrame, 0, 0);
			
			const imageData = employeeCanvasFrame.toDataURL('image/png');
			referencePhotoInput.value = imageData;
			employeePreviewImg.src = imageData;
			employeePreview.style.display = 'block';
			employeeSnapFrame.style.display = 'none';
			employeeClearFrame.style.display = 'inline-block';
		});

		// Limpiar y tomar otra foto
		employeeClearFrame.addEventListener('click', function() {
			referencePhotoInput.value = '';
			employeePreview.style.display = 'none';
			employeeSnapFrame.style.display = 'inline-block';
			employeeClearFrame.style.display = 'none';
		});

		// Inicializar cuando se carga la página
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initEmployeeWebcam);
		} else {
			initEmployeeWebcam();
		}

		// Detener webcam al enviar formulario
		document.querySelector('form[name="empleados"]')?.addEventListener('submit', function() {
			if (employeeStream) {
				employeeStream.getTracks().forEach(track => track.stop());
			}
		});
	</script>