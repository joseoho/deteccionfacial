@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Detección Facial')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600"><i class="fas fa-home"></i> Inicio</a></li>
    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
    <li class="text-gray-900">Dashboard</li>
@endsection

@section('content')
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">
                    <i class="fas fa-hand-sparkles mr-3"></i>Bienvenido
                </h1>
                <p class="text-indigo-100 text-lg">Sistema de Control de Asistencia con Reconocimiento Facial</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-face-recognition text-8xl opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide">Total Empleados</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalEmpleados ?? 0 }}</p>
                </div>
                <div class="bg-indigo-100 rounded-full p-4">
                    <i class="fas fa-users text-indigo-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide">Registros Hoy</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $registrosHoy ?? 0 }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <i class="fas fa-calendar-day text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide">Total Registros</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalRegistros ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-4">
                    <i class="fas fa-history text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('IngresoEmpleado.create') }}" class="group bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:-translate-y-1 border-2 border-transparent hover:border-indigo-500">
            <div class="text-center">
                <div class="bg-indigo-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 group-hover:bg-indigo-600 transition-colors">
                    <i class="fas fa-camera text-indigo-600 text-2xl group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Registrar Ingreso/Salida</h3>
                <p class="text-gray-600 text-sm">Reconocimiento facial automático</p>
            </div>
        </a>

        <a href="{{ route('Empleado.index') }}" class="group bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:-translate-y-1 border-2 border-transparent hover:border-green-500">
            <div class="text-center">
                <div class="bg-green-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 group-hover:bg-green-600 transition-colors">
                    <i class="fas fa-users text-green-600 text-2xl group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Gestión de Empleados</h3>
                <p class="text-gray-600 text-sm">Administrar empleados</p>
            </div>
        </a>

        <a href="{{ route('Historico.index') }}" class="group bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:-translate-y-1 border-2 border-transparent hover:border-purple-500">
            <div class="text-center">
                <div class="bg-purple-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 group-hover:bg-purple-600 transition-colors">
                    <i class="fas fa-history text-purple-600 text-2xl group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Consultar Histórico</h3>
                <p class="text-gray-600 text-sm">Ver registros de asistencia</p>
            </div>
        </a>

        <a href="{{ route('ReporteIngresosDiarios.index') }}" class="group bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all transform hover:-translate-y-1 border-2 border-transparent hover:border-yellow-500">
            <div class="text-center">
                <div class="bg-yellow-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 group-hover:bg-yellow-600 transition-colors">
                    <i class="fas fa-chart-bar text-yellow-600 text-2xl group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Reportes</h3>
                <p class="text-gray-600 text-sm">Generar reportes</p>
            </div>
        </a>
    </div>

    <!-- Features & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Features -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-star text-yellow-500 mr-3"></i>Características del Sistema
            </h3>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="bg-indigo-100 rounded-lg p-3 mr-4">
                        <i class="fas fa-face-recognition text-indigo-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Reconocimiento Facial</h4>
                        <p class="text-gray-600 text-sm">Identificación automática mediante AWS Rekognition</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-green-100 rounded-lg p-3 mr-4">
                        <i class="fas fa-clock text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Control de Tiempo</h4>
                        <p class="text-gray-600 text-sm">Registro automático de entradas y salidas</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-purple-100 rounded-lg p-3 mr-4">
                        <i class="fas fa-chart-line text-purple-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Reportes Detallados</h4>
                        <p class="text-gray-600 text-sm">Análisis completo de asistencia</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-yellow-100 rounded-lg p-3 mr-4">
                        <i class="fas fa-mobile-alt text-yellow-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Interfaz Moderna</h4>
                        <p class="text-gray-600 text-sm">Diseño responsive y fácil de usar</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-clock text-indigo-600 mr-3"></i>Registros Recientes
            </h3>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @forelse($ultimosRegistros ?? [] as $registro)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            <div class="bg-indigo-100 rounded-full p-2 mr-3">
                                <i class="fas fa-user text-indigo-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $registro->cinumber }}</p>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-calendar mr-1"></i>{{ $registro->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $registro->type == 'entrada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ strtoupper($registro->type ?? 'N/A') }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p>No hay registros recientes</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
