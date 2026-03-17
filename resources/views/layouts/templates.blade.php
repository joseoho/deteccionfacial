<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
  <script src="https://code.jquery.com/jquery-3.6.0.js" 
          integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
          crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
  <title>@yield('title', 'TimeWork v2 | Sistema de Control de Asistencia')</title>
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/font-awesome/css/all.min.css')}}">
  
  <!-- Vendor CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.addons.css')}}">
  
  <!-- Main CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/toastr.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
  <!-- Custom Styles -->
  <style>
    :root {
      --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
      --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .navbar {
      background: var(--primary-gradient) !important;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .sidebar {
      background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }
    
    .sidebar .nav-item .nav-link {
      transition: all 0.3s ease;
      border-radius: 8px;
      margin: 5px 10px;
    }
    
    .sidebar .nav-item .nav-link:hover {
      background: rgba(102, 126, 234, 0.2);
      transform: translateX(5px);
    }
    
    .sidebar .nav-item.active .nav-link {
      background: var(--primary-gradient);
      color: white;
    }
    
    .footer {
      background: #f8f9fa;
      border-top: 1px solid #e9ecef;
      padding: 20px 0;
    }
  </style>
  
  @livewireStyles
  @yield('styles')
  
  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png')}}">
</head>
<body>
  <div class="container-scroller">
    @include('layouts.partials.nav')
    <div class="container-fluid page-body-wrapper">
      @include('layouts.partials.sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        @include('layouts.partials.footer')
      </div>
    </div>
  </div>
  @include('layouts.partials.foot')
</body>
</html>
