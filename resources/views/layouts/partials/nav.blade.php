<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="/home">
      <i class="fas fa-clock mr-2"></i>
      <strong>TimeWork v2</strong>
    </a>
    <a class="navbar-brand brand-logo-mini" href="/home">
      <i class="fas fa-clock"></i>
    </a>
  </div>
  
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="fas fa-bars"></span>
    </button>
    
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('IngresoEmpleado.create') }}" title="Registrar Ingreso/Salida">
          <i class="fas fa-camera fa-lg"></i>
          <span class="d-none d-md-inline ml-2">Registro Rápido</span>
        </a>
      </li>
      
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <div class="nav-profile-img">
            <i class="fas fa-user-circle fa-2x text-white"></i>
          </div>
          <div class="nav-profile-text d-none d-md-block">
            <span class="font-weight-bold">Usuario</span>
            <span class="text-secondary">Sistema</span>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <div class="dropdown-header">
            <div class="d-flex align-items-center">
              <div class="mr-3">
                <i class="fas fa-user-circle fa-3x text-primary"></i>
              </div>
              <div>
                <p class="mb-0 font-weight-bold">Usuario del Sistema</p>
                <small class="text-muted">TimeWork v2</small>
              </div>
            </div>
          </div>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/home">
            <i class="fas fa-home text-primary mr-2"></i>
            Dashboard
          </a>
          <a class="dropdown-item" href="{{ route('Empleado.index') }}">
            <i class="fas fa-users text-info mr-2"></i>
            Empleados
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <i class="fas fa-cog text-secondary mr-2"></i>
            Configuración
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt text-danger mr-2"></i>
            Salir
          </a>
          {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form> --}}
        </div>
      </li>
    </ul>
    
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="fas fa-bars"></span>
    </button>
  </div>
</nav>

<style>
  .navbar-brand {
    font-size: 1.5rem;
    font-weight: bold;
    color: white !important;
    text-decoration: none;
    display: flex;
    align-items: center;
  }
  
  .navbar-brand:hover {
    color: rgba(255, 255, 255, 0.9) !important;
  }
  
  .navbar-brand i {
    font-size: 1.8rem;
  }
  
  .nav-profile-img {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
  }
  
  .nav-profile-text {
    margin-left: 10px;
  }
  
  .nav-link {
    color: rgba(255, 255, 255, 0.9) !important;
    transition: all 0.3s;
  }
  
  .nav-link:hover {
    color: white !important;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
  }
  
  .dropdown-menu {
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    border-radius: 12px;
    padding: 10px 0;
  }
  
  .dropdown-item {
    padding: 10px 20px;
    transition: all 0.3s;
  }
  
  .dropdown-item:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateX(5px);
  }
  
  .dropdown-header {
    padding: 15px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0;
  }
</style>
