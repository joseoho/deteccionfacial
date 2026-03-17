@extends('layouts.app')

@section('title', 'Reporte de Ingresos Diarios')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600"><i class="fas fa-home"></i> Inicio</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li><a href="{{ route('ReporteIngresosDiarios.index') }}" class="text-gray-500 hover:text-indigo-600">Reportes Diarios</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li class="text-gray-900">Resultados</li>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6">
        <!-- Header del Reporte -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-6 border-b">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-chart-bar text-indigo-600 mr-3"></i>Reporte de Ingresos por Empleados
                </h2>
                <p class="text-gray-600 mt-1">
                    Período: {{ $fi->format('d/m/Y') }} - {{ $ff->format('d/m/Y') }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Generado el: {{ $date->format('d/m/Y H:i:s') }}
                </p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <button onclick="window.print()" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-print mr-2"></i>Imprimir
                </button>
                <a href="{{ route('ReporteIngresosDiarios.index') }}" 
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>

        @if(isset($ingresos) && $ingresos->count() > 0)
            <!-- Resumen -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-indigo-50 rounded-lg p-4 border-l-4 border-indigo-500">
                    <p class="text-sm font-medium text-gray-600">Total de Registros</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $ingresos->count() }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-600">Empleados Únicos</p>
                    <p class="text-2xl font-bold text-green-600">{{ $ingresos->pluck('cinumber')->unique()->count() }}</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4 border-l-4 border-purple-500">
                    <p class="text-sm font-medium text-gray-600">Período</p>
                    <p class="text-lg font-bold text-purple-600">{{ $fi->diffInDays($ff) + 1 }} días</p>
                </div>
            </div>

            <!-- Tabla de Resultados -->
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
                                    <span class="text-sm font-medium text-gray-900">{{ $ingreso->name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">
                                        {{ \Carbon\Carbon::parse($ingreso->timestamp)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($ingreso->timestamp)->format('H:i:s') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                            N/A
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Footer del Reporte -->
            <div class="mt-6 pt-6 border-t text-center text-sm text-gray-500">
                <p>Reporte generado el {{ $date->format('d/m/Y') }} a las {{ $date->format('H:i:s') }}</p>
                <p class="mt-1">Sistema de Detección Facial - Control de Asistencia</p>
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-gray-100 rounded-full p-6 w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-inbox text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay registros disponibles</h3>
                <p class="text-gray-600 mb-4">No se encontraron registros para el rango de fechas seleccionado</p>
                <a href="{{ route('ReporteIngresosDiarios.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Volver a Consultar
                </a>
            </div>
        @endif
    </div>

    <!-- Estilos para impresión -->
    <style>
        @media print {
            nav, footer, .no-print {
                display: none !important;
            }
            body {
                background: white;
            }
            .bg-white {
                box-shadow: none;
            }
        }
    </style>
@endsection
