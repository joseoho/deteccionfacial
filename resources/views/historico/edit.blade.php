@extends('layouts.app')

@section('title', 'Editar Registro Histórico')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600"><i class="fas fa-home"></i> Inicio</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li><a href="{{ route('Historico.index') }}" class="text-gray-500 hover:text-indigo-600">Histórico</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li><a href="{{ route('Historico.show', $ingreso->id) }}" class="text-gray-500 hover:text-indigo-600">Detalle</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li class="text-gray-900">Editar</li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Formulario de Edición -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-edit text-indigo-600 mr-3"></i>Editar Registro Histórico
                </h2>

                <form action="{{ route('Historico.update', $ingreso->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Información Actual -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Información Actual del Registro</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">ID:</span>
                                    <span class="font-semibold text-gray-900 ml-2">#{{ $ingreso->id }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Cédula:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $ingreso->cinumber }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Fecha Actual:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $ingreso->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Hora Actual:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $ingreso->created_at->format('H:i:s') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Campo de Edición -->
                        <div>
                            <label for="hora" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clock mr-2"></i>Nueva Fecha y Hora <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" 
                                   name="hora" 
                                   id="hora" 
                                   value="{{ old('hora', $ingreso->created_at->format('Y-m-d\TH:i')) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('hora') border-red-500 @enderror">
                            @error('hora')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Seleccione la nueva fecha y hora para este registro
                            </p>
                        </div>

                        <!-- Información Adicional (Solo lectura) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-id-card mr-2"></i>Cédula
                                </label>
                                <input type="text" 
                                       value="{{ $ingreso->cinumber }}" 
                                       disabled
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                            </div>

                            @if($ingreso->type)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-tag mr-2"></i>Tipo
                                    </label>
                                    <input type="text" 
                                           value="{{ strtoupper($ingreso->type) }}" 
                                           disabled
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="mt-8 flex justify-end space-x-4 border-t pt-6">
                        <a href="{{ route('Historico.show', $ingreso->id) }}" 
                           class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold shadow-lg">
                            <i class="fas fa-save mr-2"></i>Actualizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Vista Previa de la Foto -->
        @if($ingreso->photourl)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center border-b pb-3">
                    <i class="fas fa-image text-indigo-600 mr-2"></i>Foto del Registro
                </h3>
                <div class="text-center">
                    <img src="{{ asset($ingreso->photourl) }}" 
                         alt="Foto del registro" 
                         class="w-full rounded-lg border-2 border-gray-200 shadow-md">
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
// Establecer el valor mínimo del datetime-local al valor actual
document.addEventListener('DOMContentLoaded', function() {
    const horaInput = document.getElementById('hora');
    if (horaInput) {
        // El valor ya está establecido desde el servidor
        // Solo agregamos validación adicional si es necesario
    }
});
</script>
@endsection
