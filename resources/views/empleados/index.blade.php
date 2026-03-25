@extends('layouts.app')

@section('title', 'Lista de Empleados')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600"><i class="fas fa-home"></i> Inicio</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li class="text-gray-900">Empleados</li>
@endsection

@section('content')
<style>
@media print {
    body * { visibility: hidden !important; }
    #area-imprimir, #area-imprimir * { visibility: visible !important; }
    #area-imprimir { position: absolute; left: 0; top: 0; width: 100%; }
    @page { size: Letter; margin: 1cm; }
    .btn, nav, header, footer { display: none !important; }
}
</style>
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-users text-indigo-600 mr-3"></i>Gestión de Empleados
                </h2>
                <p class="text-gray-600 mt-1">Administra los empleados del sistema</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <button onclick="window.print()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-print mr-2"></i>Imprimir
                </button>
                <a href="{{ route('Empleado.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-plus-circle mr-2"></i>Nuevo Empleado
                </a>
            </div>
        </div>

        <!-- Barra de Búsqueda y Filtros -->
        <form method="GET" action="{{ route('Empleado.index') }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Buscar por nombre, cédula o rol..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <select name="status" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">Todos los estados</option>
                        <option value="ACTIVO" {{ request('status') == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                        <option value="VACACIONES" {{ request('status') == 'VACACIONES' ? 'selected' : '' }}>VACACIONES</option>
                        <option value="REPOSO" {{ request('status') == 'REPOSO' ? 'selected' : '' }}>REPOSO</option>
                        <option value="INACTIVO" {{ request('status') == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                    </select>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" 
                            class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('Empleado.index') }}" 
                           class="px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
                           title="Limpiar búsqueda">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        @if($empleados->count() > 0)
            <!-- Información de resultados -->
<div id="area-imprimir">
            <div class="mb-4 text-sm text-gray-600">
                Mostrando <span class="font-semibold">{{ $empleados->firstItem() }}</span> a 
                <span class="font-semibold">{{ $empleados->lastItem() }}</span> de 
                <span class="font-semibold">{{ $empleados->total() }}</span> empleados
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
                                <i class="fas fa-user mr-2"></i>Nombre
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-briefcase mr-2"></i>Rol
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-info-circle mr-2"></i>Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-info-circle mr-2"></i>Foto
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-cog mr-2"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($empleados as $empleado)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">#{{ $empleado->id }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-sm font-medium bg-gray-100 text-gray-800 rounded-full">
                                        {{ $empleado->cinumber }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $empleado->name }}</span>
                                        @if($empleado->reference_photo_url)
                                            <i class="fas fa-check-circle text-green-500 ml-2" title="Foto de referencia registrada"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">{{ $empleado->role ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- <span class="text-sm text-gray-600">{{ $empleado->reference_photo_url ?? 'N/A' }}</span> --}}
                                    <img src="{{ asset($empleado->reference_photo_url) }}" alt="Foto de referencia" class="w-10 h-10 rounded-full">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('Empleado.edit', $empleado) }}" 
                                           class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('Empleado.destroy', $empleado) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors"
                                                    title="Eliminar"
                                                    onclick="return confirm('¿Está seguro de eliminar este empleado?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($empleados->hasPages())
                <div class="mt-6 pt-6 border-t border-gray-200">
                    {{ $empleados->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="bg-gray-100 rounded-full p-6 w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-users text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    @if(request('search') || request('status'))
                        No se encontraron empleados con los criterios de búsqueda
                    @else
                        No hay empleados registrados
                    @endif
                </h3>
                <p class="text-gray-600 mb-4">
                    @if(request('search') || request('status'))
                        Intenta con otros términos de búsqueda
                    @else
                        Comienza agregando tu primer empleado al sistema
                    @endif
                </p>
                @if(request('search') || request('status'))
                    <a href="{{ route('Empleado.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors mr-2">
                        <i class="fas fa-times mr-2"></i>Limpiar Búsqueda
                    </a>
                @endif
                <a href="{{ route('Empleado.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-plus-circle mr-2"></i>Crear Primer Empleado
                </a>
            </div>
        @endif
    </div>
@endsection
