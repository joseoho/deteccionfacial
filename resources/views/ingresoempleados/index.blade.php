@extends('layouts.app')

@section('title', 'Listado de Ingresos')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600"><i class="fas fa-home"></i> Inicio</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li class="text-gray-900">Registros de Ingreso</li>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-list text-indigo-600 mr-3"></i>Lista de Ingresos
                </h2>
                <p class="text-gray-600 mt-1">Historial de entradas y salidas</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('IngresoEmpleado.create') }}" 
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-plus-circle mr-2"></i>Nuevo Registro
                </a>
            </div>
        </div>

        <!-- Barra de Búsqueda y Filtros -->
        <form method="GET" action="{{ route('IngresoEmpleado.index') }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="md:col-span-2">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Buscar por cédula..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <select name="type" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">Todos los tipos</option>
                        <option value="ingreso" {{ request('type') == 'ingreso' ? 'selected' : '' }}>ENTRADA</option>
                        <option value="salida" {{ request('type') == 'salida' ? 'selected' : '' }}>SALIDA</option>
                    </select>
                </div>
                <div>
                    <input type="date" 
                           name="fecha" 
                           value="{{ request('fecha') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                </div>
                <div class="flex space-x-2">
                    <button type="submit" 
                            class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                    @if(request('search') || request('type') || request('fecha'))
                        <a href="{{ route('IngresoEmpleado.index') }}" 
                           class="px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
                           title="Limpiar búsqueda">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        @if(isset($ingresos) && $ingresos->count() > 0)
            <!-- Información de resultados -->
            <div class="mb-4 text-sm text-gray-600">
                Mostrando <span class="font-semibold">{{ $ingresos->firstItem() }}</span> a 
                <span class="font-semibold">{{ $ingresos->lastItem() }}</span> de 
                <span class="font-semibold">{{ $ingresos->total() }}</span> registros
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-2"></i>ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-id-card mr-2"></i>Cédula
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-image mr-2"></i>Foto
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2"></i>Fecha
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-clock mr-2"></i>Hora
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-tag mr-2"></i>Tipo
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($ingresos as $ingreso)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">#{{ $ingreso->id }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-sm font-medium bg-gray-100 text-gray-800 rounded-full">
                                        {{ $ingreso->cinumber }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($ingreso->photourl)
                                        <a href="{{ asset($ingreso->photourl) }}" target="_blank" class="inline-block">
                                            <img src="{{ asset($ingreso->photourl) }}" 
                                                 alt="Foto del registro" 
                                                 class="w-16 h-16 object-cover rounded-lg border-2 border-gray-200 hover:border-indigo-500 transition-colors cursor-pointer"
                                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'64\' height=\'64\'%3E%3Crect fill=\'%23ddd\' width=\'64\' height=\'64\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23999\'%3ENo Image%3C/text%3E%3C/svg%3E'">
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm">Sin foto</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">
                                        {{ $ingreso->created_at->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">
                                        {{ $ingreso->created_at->format('H:i:s') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($ingreso->type == 'ingreso')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-sign-in-alt mr-1"></i>ENTRADA
                                        </span>
                                    @elseif($ingreso->type == 'salida')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-sign-out-alt mr-1"></i>SALIDA
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            N/A
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($ingresos->hasPages())
                <div class="mt-6 pt-6 border-t border-gray-200">
                    {{ $ingresos->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="bg-gray-100 rounded-full p-6 w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-inbox text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    @if(request('search') || request('type') || request('fecha'))
                        No se encontraron registros con los criterios de búsqueda
                    @else
                        No hay registros disponibles
                    @endif
                </h3>
                <p class="text-gray-600 mb-4">
                    @if(request('search') || request('type') || request('fecha'))
                        Intenta con otros términos de búsqueda
                    @else
                        Comienza registrando el primer ingreso
                    @endif
                </p>
                @if(request('search') || request('type') || request('fecha'))
                    <a href="{{ route('IngresoEmpleado.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors mr-2">
                        <i class="fas fa-times mr-2"></i>Limpiar Búsqueda
                    </a>
                @endif
                <a href="{{ route('IngresoEmpleado.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-plus-circle mr-2"></i>Crear Primer Registro
                </a>
            </div>
        @endif
    </div>
@endsection
