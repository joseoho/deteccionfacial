@extends('layouts.app')

@section('title', 'Registrar Ingreso/Salida')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600"><i class="fas fa-home"></i> Inicio</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li><a href="{{ route('IngresoEmpleado.index') }}" class="text-gray-500 hover:text-indigo-600">Registro de Ingreso</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li class="text-gray-900">Nuevo Registro</li>
    
@endsection

@section('styles')
<style>
    .video-container {
        position: relative;
        width: 100%;
        max-width: 640px;
        margin: 0 auto;
        background: #000;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    
    #video_frame {
        width: 100%;
        height: auto;
        display: block;
    }
    
    .video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .face-guide {
        width: 280px;
        height: 350px;
        border: 3px solid rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        position: relative;
    }
    
    .face-guide::before {
        content: '';
        position: absolute;
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: 20%;
        border: 2px solid rgba(255, 255, 255, 0.6);
        border-radius: 50%;
    }
    
    #canvas_frame {
        display: none;
    }
    
    .preview-image {
        max-width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>
@endsection

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-camera text-indigo-600 mr-3"></i>Reconocimiento Facial
                </h2>

                @include('ingresoempleados.form')
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Instructions -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-lg font-bold mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>Instrucciones
                </h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1"></i>
                        <span>Posicione su rostro dentro del círculo</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1"></i>
                        <span>Asegúrese de tener buena iluminación</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1"></i>
                        <span>Mire directamente a la cámara</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1"></i>
                        <span>El sistema detectará automáticamente su identidad</span>
                    </li>
                </ul>
            </div>

            <!-- Recent Records -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-clock text-indigo-600 mr-2"></i>Registros Recientes
                </h3>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @if(isset($ingresos) && $ingresos->count() > 0)
                        @foreach($ingresos->take(5) as $ingreso)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $ingreso->cinumber }}</p>
                                    <p class="text-xs text-gray-600">
                                        <i class="fas fa-calendar mr-1"></i>{{ $ingreso->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $ingreso->type == 'ingreso' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ strtoupper($ingreso->type ?? 'N/A') }}
                                </span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-center py-4">No hay registros recientes</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
// Variables globales
const videoFrame = document.getElementById('video_frame');
const canvasFrame = document.getElementById('canvas_frame');
const snapFrame = document.getElementById('snap_frame');
const retakeFrame = document.getElementById('retake_frame');
const previewContainer = document.getElementById('previewContainer');
const previewImage = document.getElementById('previewImage');
const statusIndicator = document.getElementById('statusIndicator');
const dataUrlInput = document.getElementById('data_url');
const ingresoForm = document.getElementById('ingresoForm');
let stream = null;
let captured = false;

// Inicializar webcam
async function init() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({
            audio: false,
            video: {
                width: { ideal: 640 },
                height: { ideal: 480 },
                facingMode: 'user'
            }
        });
        videoFrame.srcObject = stream;
    } catch (e) {
        console.error('Error accessing webcam:', e);
        alert('No se pudo acceder a la cámara. Por favor, permita el acceso a la cámara en la configuración del navegador.');
    }
}

// Capturar imagen
if (snapFrame) {
    snapFrame.addEventListener('click', function() {
        if (!stream) {
            alert('La cámara no está lista. Por favor, espere un momento.');
            return;
        }
        
        const context = canvasFrame.getContext('2d');
        canvasFrame.width = videoFrame.videoWidth;
        canvasFrame.height = videoFrame.videoHeight;
        context.drawImage(videoFrame, 0, 0, canvasFrame.width, canvasFrame.height);
        
        const imageData = canvasFrame.toDataURL('image/png');
        dataUrlInput.value = imageData;
        if (previewImage) {
            previewImage.src = imageData;
        }
        
        // Mostrar preview
        if (previewContainer) {
            previewContainer.style.display = 'block';
        }
        snapFrame.style.display = 'none';
        if (retakeFrame) {
            retakeFrame.style.display = 'inline-block';
        }
        captured = true;
        
        // Detener video stream
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        
        // Cambiar estado
        if (statusIndicator) {
            statusIndicator.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800';
            statusIndicator.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Procesando...';
        }
        
        // Auto-enviar formulario después de un breve delay
        setTimeout(() => {
            if (statusIndicator) {
                statusIndicator.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800';
                statusIndicator.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Enviando...';
            }
            ingresoForm.submit();
        }, 500);
    });
}

// Retomar foto
if (retakeFrame) {
    retakeFrame.addEventListener('click', function() {
        captured = false;
        if (previewContainer) {
            previewContainer.style.display = 'none';
        }
        snapFrame.style.display = 'inline-block';
        retakeFrame.style.display = 'none';
        dataUrlInput.value = '';
        
        // Reiniciar webcam
        init();
    });
}

// Inicializar cuando se carga la página
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

// Detener webcam al enviar formulario
if (ingresoForm) {
    ingresoForm.addEventListener('submit', function() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    });
}

// Permitir Enter para capturar
const empleadoIdInput = document.getElementById('empleado_id');
if (empleadoIdInput) {
    empleadoIdInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !captured && snapFrame) {
            e.preventDefault();
            snapFrame.click();
        }
    });
}
</script>
@endsection
