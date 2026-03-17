@extends('layouts.app')

@section('title', 'Consultar Histórico')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600"><i class="fas fa-home"></i> Inicio</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li class="text-gray-900">Consultar Histórico</li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulario -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-history text-indigo-600 mr-3"></i>Consultar Histórico por Empleado
                </h2>

                <form action="{{ route('Historico.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label for="empleado_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2"></i>Empleado <span class="text-red-500">*</span>
                            </label>
                            <select name="empleado_id" 
                                    id="empleado_id" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('empleado_id') border-red-500 @enderror">
                                <option value="">--- Seleccione un empleado ---</option>
                                @foreach ($empleados as $empleado)
                                    <option value="{{ $empleado->cinumber }}" {{ old('empleado_id') == $empleado->cinumber ? 'selected' : '' }}>
                                        {{ $empleado->name }} ({{ $empleado->cinumber }})
                                    </option>
                                @endforeach
                            </select>
                            @error('empleado_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="fecha_ini" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt mr-2"></i>Fecha Inicio <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="fecha_ini" 
                                       id="fecha_ini" 
                                       value="{{ old('fecha_ini') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('fecha_ini') border-red-500 @enderror">
                                @error('fecha_ini')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-check mr-2"></i>Fecha Fin <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="fecha_fin" 
                                       id="fecha_fin" 
                                       value="{{ old('fecha_fin') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('fecha_fin') border-red-500 @enderror">
                                @error('fecha_fin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4 border-t pt-6">
                        <a href="{{ route('home') }}" 
                           class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                            <i class="fas fa-arrow-left mr-2"></i>Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold shadow-lg">
                            <i class="fas fa-search mr-2"></i>Consultar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-lg font-bold mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>Información
                </h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1"></i>
                        <span>Seleccione un empleado</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1"></i>
                        <span>Elija el rango de fechas</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1"></i>
                        <span>Obtenga el historial completo</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1"></i>
                        <span>Vea entradas y salidas</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
$(document).ready(function() {
    $('#empleado_id').select2({
        placeholder: 'Seleccione un empleado',
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection
