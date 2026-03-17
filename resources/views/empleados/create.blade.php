@extends('layouts.app')

@section('title', 'Crear Nuevo Empleado')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600"><i class="fas fa-home"></i> Inicio</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li><a href="{{ route('Empleado.index') }}" class="text-gray-500 hover:text-indigo-600">Empleados</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li class="text-gray-900">Nuevo Empleado</li>
@endsection

@section('styles')
<style>
    .video-container {
        position: relative;
        width: 100%;
        max-width: 400px;
        background: #000;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    #employee_video_frame {
        width: 100%;
        height: auto;
        display: block;
    }
    
    #employee_canvas_frame {
        display: none;
    }
    
    .preview-image {
        max-width: 100%;
        border-radius: 12px;
        border: 3px solid #10b981;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-user-plus text-indigo-600 mr-3"></i>Crear Nuevo Empleado
        </h2>

        <form action="{{ route('Empleado.store') }}" method="POST" id="employeeForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información Básica -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">
                        <i class="fas fa-info-circle text-indigo-600 mr-2"></i>Información Básica
                    </h3>

                    <div>
                        <label for="cinumber" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-id-card mr-2"></i>Cédula <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="cinumber" 
                               id="cinumber" 
                               value="{{ old('cinumber') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('cinumber') border-red-500 @enderror"
                               placeholder="Ingrese número de cédula">
                        @error('cinumber')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2"></i>Nombre Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('name') border-red-500 @enderror"
                               placeholder="Ingrese nombre completo">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-briefcase mr-2"></i>Cargo/Rol
                        </label>
                        <input type="text" 
                               name="role" 
                               id="role" 
                               value="{{ old('role') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                               placeholder="Ej: Desarrollador, Gerente, etc.">
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Estado <span class="text-red-500">*</span>
                        </label>
                        <select name="status" 
                                id="status" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('status') border-red-500 @enderror">
                            <option value="">Seleccione un estado</option>
                            <option value="ACTIVO" {{ old('status') == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                            <option value="VACACIONES" {{ old('status') == 'VACACIONES' ? 'selected' : '' }}>VACACIONES</option>
                            <option value="REPOSO" {{ old('status') == 'REPOSO' ? 'selected' : '' }}>REPOSO</option>
                            <option value="INACTIVO" {{ old('status') == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sticky-note mr-2"></i>Notas
                        </label>
                        <textarea name="note" 
                                  id="note" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                  placeholder="Notas adicionales sobre el empleado">{{ old('note') }}</textarea>
                    </div>
                </div>

                <!-- Foto de Referencia -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">
                        <i class="fas fa-camera text-indigo-600 mr-2"></i>Foto de Referencia
                    </h3>

                    <div>
                        <p class="text-sm text-gray-600 mb-4">
                            <i class="fas fa-info-circle mr-1"></i>
                            Capture una foto clara del rostro del empleado para el reconocimiento facial
                        </p>

                        <div class="video-container mb-4">
                            <video id="employee_video_frame" autoplay playsinline muted></video>
                        </div>

                        <div class="flex space-x-3 mb-4">
                            <button type="button" 
                                    id="employee_snap_frame" 
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                <i class="fas fa-camera mr-2"></i>Capturar Foto
                            </button>
                            <button type="button" 
                                    id="employee_clear_frame" 
                                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors" 
                                    style="display: none;">
                                <i class="fas fa-redo mr-2"></i>Tomar Otra
                            </button>
                        </div>

                        <div id="employee_preview" style="display: none;" class="text-center">
                            <img id="employee_preview_img" class="preview-image mx-auto mb-2" src="" alt="Preview">
                            <p class="text-sm text-green-600">
                                <i class="fas fa-check-circle"></i> Foto capturada
                            </p>
                        </div>

                        <canvas id="employee_canvas_frame"></canvas>
                        <input type="hidden" name="reference_photo" id="reference_photo" value="">
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="mt-8 flex justify-end space-x-4 border-t pt-6">
                <a href="{{ route('Empleado.index') }}" 
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold shadow-lg">
                    <i class="fas fa-save mr-2"></i>Guardar Empleado
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
// Variables globales
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
            video: { 
                width: { ideal: 640 },
                height: { ideal: 480 },
                facingMode: 'user'
            }
        });
        employeeVideoFrame.srcObject = employeeStream;
    } catch (e) {
        console.error('Error accessing webcam:', e);
        alert('No se pudo acceder a la cámara. Por favor, permita el acceso a la cámara.');
    }
}

// Capturar foto
employeeSnapFrame.addEventListener('click', function() {
    if (!employeeStream) {
        alert('La cámara no está lista. Por favor, espere un momento.');
        return;
    }

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

    // Detener video stream
    if (employeeStream) {
        employeeStream.getTracks().forEach(track => track.stop());
        employeeStream = null;
    }
});

// Limpiar y tomar otra foto
employeeClearFrame.addEventListener('click', function() {
    referencePhotoInput.value = '';
    employeePreview.style.display = 'none';
    employeeSnapFrame.style.display = 'inline-block';
    employeeClearFrame.style.display = 'none';
    
    // Reiniciar webcam
    initEmployeeWebcam();
});

// Inicializar cuando se carga la página
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initEmployeeWebcam);
} else {
    initEmployeeWebcam();
}

// Detener webcam al enviar formulario
document.getElementById('employeeForm').addEventListener('submit', function() {
    if (employeeStream) {
        employeeStream.getTracks().forEach(track => track.stop());
    }
});
</script>
@endsection
