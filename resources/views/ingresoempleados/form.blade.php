<form action="{{ route('IngresoEmpleado.store') }}" method="POST" name="IngresoEmpleado" enctype="multipart/form-data" id="ingresoForm">
    @csrf
    
    <div class="mb-6">
        <label for="empleado_id" class="block text-sm font-medium text-gray-700 mb-2">
            {{-- <i class="fas fa-id-card mr-2"></i><strong>Cédula (Opcional - Se detectará automáticamente)</strong> --}}
            <i class="fas fa-id-card mr-2"></i><strong>Inroduzca Cédula </strong>
        </label>
        <input type="number" 
               name="empleado_id" 
               id="empleado_id" 
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
               placeholder="Ingrese número de cédula/Id Empleado" 
               autofocus>
        {{-- <p class="mt-2 text-sm text-gray-600">
            <i class="fas fa-info-circle mr-1"></i>
            Si no ingresa la cédula, el sistema intentará reconocerla automáticamente mediante reconocimiento facial
        </p> --}}
        <p class="mt-2 text-sm text-gray-600">
            <i class="fas fa-info-circle mr-1"></i>
            Introduzca su documento de identidad y presione la tecla Enter, para capturar su rostro y registrar su ingreso/salida
        </p> 
    </div>
    
    <div class="video-container mb-6">
        <video id="video_frame" preload="true" playsinline autoplay muted></video>
        <div class="video-overlay">
            <div class="face-guide"></div>
        </div>
    </div>
    
    <div class="flex justify-center space-x-4 mb-6">
        <button type="button" id="snap_frame" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold shadow-lg">
            <i class="fas fa-camera mr-2"></i>Capturar y Registrar
        </button>
        <button type="button" id="retake_frame" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold shadow-lg" style="display: none;">
            <i class="fas fa-redo mr-2"></i>Tomar Otra Foto
        </button>
    </div>
    
    <div class="text-center" id="previewContainer" style="display: none;">
        <img id="previewImage" class="preview-image mx-auto mb-4" src="" alt="Preview">
        <div>
            <span id="statusIndicator" class="px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                <i class="fas fa-spinner fa-spin mr-2"></i>Procesando...
            </span>
        </div>
    </div>
    
    <canvas id="canvas_frame"></canvas>
    <input type="hidden" name="data_url" id="data_url" value="">
</form>
