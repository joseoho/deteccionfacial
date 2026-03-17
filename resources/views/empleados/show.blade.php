@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600"><i class="fas fa-home"></i> Inicio</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li><a href="{{ route('Empleado.index') }}" class="text-gray-500 hover:text-indigo-600">Empleados</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li class="text-gray-900">Detalles</li>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Header con acciones -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-user text-indigo-600 mr-3"></i>{{ $empleado->name }}
                    </h2>
                    <p class="text-gray-600 mt-1">Cédula: {{ $empleado->cinumber }}</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <a href="{{ route('Empleado.edit', $empleado) }}" 
                       class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                    <a href="{{ route('Empleado.index') }}" 
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información Básica -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center border-b pb-3">
                        <i class="fas fa-info-circle text-indigo-600 mr-2"></i>Información Básica
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Cédula</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $empleado->cinumber }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nombre</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $empleado->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Cargo/Rol</label>
                            <p class="text-lg text-gray-900">{{ $empleado->role ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Estado</label>
                            <div>
                                @if($empleado->status == 'ACTIVO')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>ACTIVO
                                    </span>
                                @elseif($empleado->status == 'VACACIONES')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-umbrella-beach mr-1"></i>VACACIONES
                                    </span>
                                @elseif($empleado->status == 'REPOSO')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-bed mr-1"></i>REPOSO
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ $empleado->status ?? 'N/A' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if($empleado->note)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Notas</label>
                                <p class="text-gray-900">{{ $empleado->note }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Fecha de Registro</label>
                            <p class="text-gray-900">{{ $empleado->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Última Actualización</label>
                            <p class="text-gray-900">{{ $empleado->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Historial de Registros -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center border-b pb-3">
                        <i class="fas fa-history text-indigo-600 mr-2"></i>Historial de Registros
                        <span class="ml-auto text-sm font-normal text-gray-500">
                            ({{ $empleado->timemarks->count() }} registros)
                        </span>
                    </h3>
                    @if($empleado->timemarks->count() > 0)
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @foreach($empleado->timemarks->take(10) as $registro)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-indigo-100 rounded-full p-3">
                                            <i class="fas fa-clock text-indigo-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">
                                                {{ $registro->type ? strtoupper($registro->type) : 'REGISTRO' }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-calendar mr-1"></i>{{ $registro->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        @if($registro->confidence)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ number_format($registro->confidence * 100, 1) }}%
                                            </span>
                                        @endif
                                        @if($registro->photourl)
                                            <a href="{{ $registro->photourl }}" 
                                               target="_blank"
                                               class="text-indigo-600 hover:text-indigo-800">
                                                <i class="fas fa-image"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3"></i>
                            <p>No hay registros de asistencia</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Foto de Referencia -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center border-b pb-3">
                        <i class="fas fa-camera text-indigo-600 mr-2"></i>Foto de Referencia
                    </h3>
                    @if($empleado->reference_photo_url)
                        <div class="text-center">
                            <img src="{{ $empleado->reference_photo_url }}" 
                                 alt="Foto de referencia" 
                                 class="w-full rounded-lg border-2 border-gray-200 shadow-md mb-3">
                            <p class="text-xs text-gray-500">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                Foto registrada para reconocimiento facial
                            </p>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-camera text-4xl mb-3"></i>
                            <p class="text-sm">No hay foto de referencia</p>
                            <a href="{{ route('Empleado.edit', $empleado) }}" 
                               class="mt-3 inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm">
                                <i class="fas fa-plus mr-1"></i>Agregar Foto
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Estadísticas -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center border-b pb-3">
                        <i class="fas fa-chart-bar text-indigo-600 mr-2"></i>Estadísticas
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                            <span class="text-gray-700 font-medium">Total Registros</span>
                            <span class="text-2xl font-bold text-blue-600">{{ $empleado->timemarks->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                            <span class="text-gray-700 font-medium">Entradas</span>
                            <span class="text-2xl font-bold text-green-600">
                                {{ $empleado->timemarks->where('type', 'entrada')->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                            <span class="text-gray-700 font-medium">Salidas</span>
                            <span class="text-2xl font-bold text-red-600">
                                {{ $empleado->timemarks->where('type', 'salida')->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
