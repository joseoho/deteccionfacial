@extends('layouts.app')

@section('title', 'Detalle de Registro Histórico')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600"><i class="fas fa-home"></i> Inicio</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li><a href="{{ route('Historico.index') }}" class="text-gray-500 hover:text-indigo-600">Histórico</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li class="text-gray-900">Detalle</li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Foto del Registro -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center border-b pb-3">
                <i class="fas fa-image text-indigo-600 mr-2"></i>Foto del Registroo
            </h3>
            <div class="text-center">
                @if($ingreso->photourl)
                    <img src="{{ asset($ingreso->photourl) }}" 
                         alt="Foto del registro" 
                         class="w-full max-w-md mx-auto rounded-lg border-2 border-gray-200 shadow-md hover:shadow-xl transition-shadow cursor-pointer"
                         onclick="window.open('{{ asset($ingreso->photourl) }}', '_blank')"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'400\'%3E%3Crect fill=\'%23ddd\' width=\'400\' height=\'400\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23999\' font-size=\'20\'%3EImagen no disponible%3C/text%3E%3C/svg%3E'">
                    <p class="text-sm text-gray-500 mt-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Haz clic en la imagen para verla en tamaño completo
                    </p>
                @else
                    <div class="bg-gray-100 rounded-lg p-12">
                        <i class="fas fa-image text-gray-400 text-6xl mb-3"></i>
                        <p class="text-gray-500">No hay foto disponible</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Información del Registro -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-6 border-b pb-3">
                <h3 class="text-lg font-bold text-gray-900 flex items-center">
                    <i class="fas fa-info-circle text-indigo-600 mr-2"></i>Información del Registro
                </h3>
                <div class="flex space-x-2">
                    <a href="{{ route('Historico.edit', $ingreso->id) }}" 
                       class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors"
                       title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                            <i class="fas fa-hashtag text-indigo-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-600">ID del Registro</span>
                    </div>
                    <span class="text-lg font-bold text-gray-900">#{{ $ingreso->id }}</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                            <i class="fas fa-id-card text-indigo-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-600">Cédula</span>
                    </div>
                    <span class="px-3 py-1 text-sm font-semibold bg-gray-100 text-gray-800 rounded-full">
                        {{ $ingreso->cinumber }}
                    </span>
                </div>

                @if($ingreso->employee)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                                <i class="fas fa-user text-indigo-600"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600">Empleado</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $ingreso->employee->name }}</span>
                    </div>
                @endif

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                            <i class="fas fa-calendar-alt text-indigo-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-600">Fecha</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900">
                        {{ $ingreso->created_at->format('d/m/Y') }}
                    </span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                            <i class="fas fa-clock text-indigo-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-600">Hora</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900">
                        {{ $ingreso->created_at->format('H:i:s') }}
                    </span>
                </div>

                @if($ingreso->type)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                                <i class="fas fa-tag text-indigo-600"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600">Tipo</span>
                        </div>
                        @if($ingreso->type == 'entrada')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-sign-in-alt mr-1"></i>ENTRADA
                            </span>
                        @elseif($ingreso->type == 'salida')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                <i class="fas fa-sign-out-alt mr-1"></i>SALIDA
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ strtoupper($ingreso->type) }}
                            </span>
                        @endif
                    </div>
                @endif

                @if($ingreso->confidence)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                                <i class="fas fa-percentage text-indigo-600"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600">Confianza de Reconocimiento</span>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold bg-blue-100 text-blue-800 rounded-full">
                            {{ number_format($ingreso->confidence * 100, 2) }}%
                        </span>
                    </div>
                @endif

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                            <i class="fas fa-calendar-check text-indigo-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-600">Registrado el</span>
                    </div>
                    <span class="text-sm text-gray-900">
                        {{ $ingreso->created_at->format('d/m/Y H:i:s') }}
                    </span>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="mt-6 pt-6 border-t flex justify-between">
                <a href="{{ route('Historico.index') }}" 
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
                <a href="{{ route('Historico.edit', $ingreso->id) }}" 
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>Editar Registro
                </a>
            </div>
        </div>
    </div>
@endsection
