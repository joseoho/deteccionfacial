<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistema de Control de Asistencia')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Animación para el reloj */
        @keyframes pulse-clock {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }
        
        .clock-container {
            animation: pulse-clock 2s ease-in-out infinite;
        }
        
        /* Estilos para el reloj */
        .clock-widget {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }
        
        .clock-widget:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
        }
        
        /* Modo pantalla completa para registro */
        .fullscreen-mode {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            background: white;
            overflow-y: auto;
        }
        
        /* Ocultar elementos en modo pantalla completa */
        .fullscreen-mode nav,
        .fullscreen-mode footer,
        .fullscreen-mode .breadcrumbs-container,
        .fullscreen-mode .clock-widget {
            display: none !important;
        }
    </style>
    
    @yield('styles')
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="clockApp()" x-init="initClock()">
    <div class="min-h-screen flex flex-col" :class="fullscreenMode ? 'fullscreen-mode' : ''">
        
        <!-- Reloj flotante (visible en todas las páginas) -->
        <div class="clock-widget fixed top-4 right-4 bg-white rounded-xl shadow-lg p-3 z-50 border border-gray-200"
             :class="fullscreenMode ? 'hidden' : ''">
            <div class="flex items-center space-x-3">
                <div class="bg-indigo-100 rounded-full p-2">
                    <i class="fas fa-clock text-indigo-600 text-xl"></i>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold font-mono text-gray-800" x-text="time"></div>
                    <div class="text-xs text-gray-500 uppercase" x-text="date"></div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg" :class="fullscreenMode ? 'hidden' : ''">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3 text-white hover:text-gray-200 transition">
                            <i class="fas fa-face-recognition text-2xl"></i>
                            <span class="text-xl font-bold">Control de Asistencia</span>
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
                        <button @click="toggleFullscreen()" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition" title="Pantalla completa">
                            <i class="fas fa-expand text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
        
       {{-- <!-- Horarios permitidos -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 mx-4 sm:mx-6 lg:mx-8" :class="fullscreenMode ? 'hidden' : ''">
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
                Hora actual: <span x-text="time"></span> - 
                <span x-text="fechaCompleta"></span>
            </div>
        </div> --}}
        
        <!-- Main Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Breadcrumbs -->
                @hasSection('breadcrumbs')
                    <nav class="mb-6 breadcrumbs-container" aria-label="Breadcrumb" :class="fullscreenMode ? 'hidden' : ''">
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
        <footer class="bg-white border-t border-gray-200 mt-auto" :class="fullscreenMode ? 'hidden' : ''">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} Control de Asistencia. Todos los derechos reservados.</p>
                    <p class="mt-2 md:mt-0">
                        <i class="fas fa-code mr-1"></i>
                        Desarrollado con Laravel & Tailwind CSS
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <script>
        function clockApp() {
            return {
                time: '',
                date: '',
                fechaCompleta: '',
                fullscreenMode: false,
                
                initClock() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                },
                
                updateClock() {
                    const now = new Date();
                    
                    // Formato 24 horas
                    this.time = now.toLocaleTimeString('es-VE', { 
                        hour: '2-digit', 
                        minute: '2-digit', 
                        second: '2-digit',
                        hour12: false
                    });
                    
                    // Fecha corta
                    this.date = now.toLocaleDateString('es-VE', {
                        weekday: 'short',
                        day: '2-digit',
                        month: 'short'
                    }).toUpperCase();
                    
                    // Fecha completa para el panel de horarios
                    this.fechaCompleta = now.toLocaleDateString('es-VE', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                },
                
                toggleFullscreen() {
                    this.fullscreenMode = !this.fullscreenMode;
                    
                    if (this.fullscreenMode) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = 'auto';
                    }
                }
            }
        }
    </script>
    
    @yield('scripts')
</body>
</html>