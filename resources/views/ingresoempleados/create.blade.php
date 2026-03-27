@extends('layouts.app')

@section('title', 'Registrar Ingreso/Salida')

@section('styles')
<style>
    /* Ocultar elementos en modo pantalla completa */
    .fullscreen-mode .registro-header,
    .fullscreen-mode .sidebar-info,
    .fullscreen-mode .recent-records {
        display: none !important;
    }
    
    .fullscreen-mode .main-content {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .fullscreen-mode .registro-card {
        min-height: 100vh;
        border-radius: 0 !important;
        box-shadow: none !important;
    }
    
    .fullscreen-mode .video-container {
        max-width: 100% !important;
        height: calc(100vh - 200px) !important;
    }
    
    .fullscreen-mode #video_frame {
        height: 100% !important;
        object-fit: cover !important;
    }
    
    /* Estilos mejorados para registro */
    .video-container {
        position: relative;
        width: 100%;
        max-width: 800px;
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
    
    /* Input de cédula estilo kiosco */
    .kiosk-input {
        font-size: 2rem;
        text-align: center;
        letter-spacing: 2px;
        font-family: monospace;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .kiosk-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        transform: scale(1.02);
    }
    
    /* Botones grandes para kiosco */
    .kiosk-btn {
        padding: 1rem 2rem;
        font-size: 1.25rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .kiosk-btn:active {
        transform: scale(0.98);
    }
    
    /* Animación de pulso para estado */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    .status-pulse {
        animation: pulse 1.5s ease-in-out infinite;
    }
</style>
@endsection

@section('content')
<div class="main-content">
    <div class="registro-card bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header con hora actual -->
        {{-- <div class="registro-header bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white">
            <div class="text-center">
                <i class="fas fa-fingerprint text-5xl mb-3"></i>
                <h1 class="text-3xl font-bold">Registro de Asistencia</h1>
                <p class="text-indigo-100 mt-2">Sistema de Control de Asistencia</p>
            </div> 
            <div class="mt-4 text-center border-t border-indigo-400 pt-4">
                <div class="text-5xl font-mono font-bold" id="horaActual"></div>
                <div class="text-lg mt-1" id="fechaActual"></div>
            </div>
        </div> --}}

        <div class="p-6">
            @include('ingresoempleados.form')
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Variables globales
let stream = null;
let captured = false;
const videoFrame = document.getElementById('video_frame');
const canvasFrame = document.getElementById('canvas_frame');
const snapFrame = document.getElementById('snap_frame');
const retakeFrame = document.getElementById('retake_frame');
const previewContainer = document.getElementById('previewContainer');
const previewImage = document.getElementById('previewImage');
const statusIndicator = document.getElementById('statusIndicator');
const dataUrlInput = document.getElementById('data_url');
const ingresoForm = document.getElementById('ingresoForm');
const empleadoIdInput = document.getElementById('empleado_id');

// Actualizar hora en tiempo real
function updateClock() {
    const now = new Date();
    const horaElement = document.getElementById('horaActual');
    const fechaElement = document.getElementById('fechaActual');
    
    if (horaElement) {
        horaElement.textContent = now.toLocaleTimeString('es-VE', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: false
        });
    }
    
    if (fechaElement) {
        fechaElement.textContent = now.toLocaleDateString('es-VE', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
}

// Inicializar webcam
async function initWebcam() {
    try {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        
        stream = await navigator.mediaDevices.getUserMedia({
            audio: false,
            video: {
                width: { ideal: 1280 },
                height: { ideal: 720 },
                facingMode: 'user'
            }
        });
        
        if (videoFrame) {
            videoFrame.srcObject = stream;
            videoFrame.onloadedmetadata = () => {
                videoFrame.play();
            };
        }
        
        if (statusIndicator) {
            statusIndicator.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800';
            statusIndicator.innerHTML = '<i class="fas fa-camera mr-1"></i>Cámara lista';
        }
        
    } catch (e) {
        console.error('Error accessing webcam:', e);
        if (statusIndicator) {
            statusIndicator.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800';
            statusIndicator.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Error de cámara';
        }
        alert('No se pudo acceder a la cámara. Por favor, permita el acceso a la cámara en la configuración del navegador.');
    }
}

// Capturar imagen
function captureImage() {
    if (!stream) {
        alert('La cámara no está lista. Por favor, espere un momento.');
        return;
    }
    
    if (!empleadoIdInput || !empleadoIdInput.value.trim()) {
        alert('Por favor, ingrese primero el número de cédula');
        empleadoIdInput?.focus();
        return;
    }
    
    if (statusIndicator) {
        statusIndicator.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 status-pulse';
        statusIndicator.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Capturando...';
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
    
    if (previewContainer) {
        previewContainer.style.display = 'block';
    }
    
    if (snapFrame) snapFrame.style.display = 'none';
    if (retakeFrame) retakeFrame.style.display = 'inline-block';
    captured = true;
    
    // Detener video stream
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    
    if (statusIndicator) {
        statusIndicator.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800';
        statusIndicator.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Foto capturada';
    }
    
    // Auto-enviar después de 500ms
    setTimeout(() => {
        if (statusIndicator) {
            statusIndicator.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800';
            statusIndicator.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Enviando registro...';
        }
        ingresoForm.submit();
    }, 500);
}

// Recapturar imagen
function recaptureImage() {
    captured = false;
    if (previewContainer) {
        previewContainer.style.display = 'none';
    }
    if (snapFrame) snapFrame.style.display = 'inline-block';
    if (retakeFrame) retakeFrame.style.display = 'none';
    if (dataUrlInput) dataUrlInput.value = '';
    
    if (statusIndicator) {
        statusIndicator.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800';
        statusIndicator.innerHTML = '<i class="fas fa-camera mr-1"></i>Reiniciando cámara...';
    }
    
    initWebcam();
}

// Atajos de teclado
function setupKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // ENTER - Capturar foto (si no está capturada)
        if (e.key === 'Enter' && !captured && snapFrame && snapFrame.style.display !== 'none') {
            e.preventDefault();
            captureImage();
        }
        
        // ESC - Limpiar y recapturar
        if (e.key === 'Escape' && captured) {
            e.preventDefault();
            recaptureImage();
            if (empleadoIdInput) {
                empleadoIdInput.value = '';
                empleadoIdInput.focus();
            }
        }
        
        // CTRL + ENTER - Enviar formulario manualmente
        if (e.ctrlKey && e.key === 'Enter' && captured) {
            e.preventDefault();
            if (statusIndicator) {
                statusIndicator.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800';
                statusIndicator.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Enviando...';
            }
            ingresoForm.submit();
        }
        
        // F5 - Recapturar
        if (e.key === 'F5') {
            e.preventDefault();
            recaptureImage();
        }
    });
}

// Configurar auto-foco en el campo de cédula
function setupAutoFocus() {
    if (empleadoIdInput) {
        empleadoIdInput.focus();
        
        // Estilo para feedback visual
        empleadoIdInput.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-indigo-500');
        });
        
        empleadoIdInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-indigo-500');
        });
    }
}

// Inicializar todo
function init() {
    updateClock();
    setInterval(updateClock, 1000);
    initWebcam();
    setupKeyboardShortcuts();
    setupAutoFocus();
}

// Configurar eventos
if (snapFrame) {
    snapFrame.addEventListener('click', captureImage);
}

if (retakeFrame) {
    retakeFrame.addEventListener('click', recaptureImage);
}

if (ingresoForm) {
    ingresoForm.addEventListener('submit', function() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    });
}

// Iniciar cuando la página carga
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
</script>
@endsection