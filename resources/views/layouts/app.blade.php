<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Detección Facial - Sistema de Control de Asistencia')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @yield('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3 text-white hover:text-gray-200 transition">
                            <i class="fas fa-face-recognition text-2xl"></i>
                            <span class="text-xl font-bold">Detección Facial</span>
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('home') ? 'bg-white bg-opacity-20' : '' }}">
                            <i class="fas fa-home mr-2"></i>Inicio
                        </a>
                        <a href="{{ route('Empleado.index') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('Empleado.*') ? 'bg-white bg-opacity-20' : '' }}">
                            <i class="fas fa-users mr-2"></i>Empleados
                        </a>
                        <a href="{{ route('IngresoEmpleado.create') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('IngresoEmpleado.*') ? 'bg-white bg-opacity-20' : '' }}">
                            <i class="fas fa-camera mr-2"></i>Registrar Ingreso
                        </a>
                    </div>
                </div>
            </div>
        </nav>
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
    <h3 class="text-blue-800 font-semibold mb-2">
        <i class="fas fa-clock mr-2"></i>Horarios permitidos:
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
        <div class="flex items-center text-green-700">
            <i class="fas fa-sign-in-alt mr-2 w-5"></i>
            <span><strong>ENTRADA:</strong> 06:00 - 09:30</span>
        </div>
        <div class="flex items-center text-red-700">
            <i class="fas fa-sign-out-alt mr-2 w-5"></i>
            <span><strong>SALIDA:</strong> 11:30 - 13:30</span>
        </div>
        <div class="flex items-center text-green-700">
            <i class="fas fa-sign-in-alt mr-2 w-5"></i>
            <span><strong>ENTRADA:</strong> 13:31 - 14:30</span>
        </div>
        <div class="flex items-center text-red-700">
            <i class="fas fa-sign-out-alt mr-2 w-5"></i>
            <span><strong>SALIDA:</strong> 17:00 en adelante</span>
        </div>
    </div>
    <div class="mt-2 text-xs text-blue-600">
        <i class="fas fa-info-circle mr-1"></i>
        Hora actual: {{ \Carbon\Carbon::now('America/Caracas')->format('h:i:s A') }}
    </div>
</div>
        <!-- Main Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Breadcrumbs -->
                @hasSection('breadcrumbs')
                    <nav class="mb-6" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 text-sm text-gray-600">
                            @yield('breadcrumbs')
                        </ol>
                    </nav>
                @endif

                <!-- Flash Messages -->
                @if (session()->has('notification'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <p class="font-medium">{{ session('notification') }}</p>
                            <button type="button" class="ml-auto text-green-700 hover:text-green-900" onclick="this.parentElement.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session()->has('noexiste'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            <p class="font-medium">{{ session('noexiste') }}</p>
                            <button type="button" class="ml-auto text-red-700 hover:text-red-900" onclick="this.parentElement.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <p class="font-medium">{{ session('success') }}</p>
                            <button type="button" class="ml-auto text-green-700 hover:text-green-900" onclick="this.parentElement.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow-sm" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle mr-3"></i>
                            <p class="font-medium">{{ session('error') }}</p>
                            <button type="button" class="ml-auto text-yellow-700 hover:text-yellow-900" onclick="this.parentElement.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} Sistema de Detección Facial. Todos los derechos reservados.</p>
                    <p class="mt-2 md:mt-0">
                        <i class="fas fa-code mr-1"></i>
                        Desarrollado con Laravel & Tailwind CSS
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>
