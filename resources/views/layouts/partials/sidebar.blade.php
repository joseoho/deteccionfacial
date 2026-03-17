<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <div class="nav-link">
        <div class="profile-image">
          <div class="profile-image-wrapper" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto;">
            <i class="fas fa-user-circle fa-3x text-white"></i>
          </div>
        </div>
        <div class="profile-name text-center mt-3">
          <p class="name mb-0" style="color: white; font-weight: bold; font-size: 1.1rem;">
            TimeWork v2
          </p>
          <p class="designation mb-0" style="color: rgba(255,255,255,0.7); font-size: 0.85rem;">
            Sistema de Control de Asistencia
          </p>
        </div>
      </div>
    </li>
    
    <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
      <a class="nav-link" href="/home">
        <i class="fas fa-home menu-icon"></i>
        <span class="menu-title">Inicio</span>
      </a>
    </li>
    
    <li class="nav-item {{ request()->is('Empleado*') ? 'active' : '' }}" id="menuempleado">
      <a class="nav-link" data-toggle="collapse" href="#employees" aria-expanded="{{ request()->is('Empleado*') ? 'true' : 'false' }}" aria-controls="employees">
        <i class="fas fa-users menu-icon"></i>
        <span class="menu-title">Empleados</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->is('Empleado*') ? 'show' : '' }}" id="employees">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('Empleado') ? 'active' : '' }}" href="{{ route('Empleado.index') }}">
              <i class="fas fa-list mr-2"></i> Lista de Empleados
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('Empleado/create') ? 'active' : '' }}" href="{{ route('Empleado.create') }}">
              <i class="fas fa-user-plus mr-2"></i> Registrar Empleado
            </a>
          </li>
        </ul>
      </div>
    </li>
    
    <li class="nav-item {{ request()->is('IngresoEmpleado*') || request()->is('Historico*') ? 'active' : '' }}">
      <a class="nav-link" data-toggle="collapse" href="#intros" aria-expanded="{{ request()->is('IngresoEmpleado*') || request()->is('Historico*') ? 'true' : 'false' }}" aria-controls="intros">
        <i class="fas fa-clock menu-icon"></i>
        <span class="menu-title">Control de Asistencia</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->is('IngresoEmpleado*') || request()->is('Historico*') ? 'show' : '' }}" id="intros">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('IngresoEmpleado/create') ? 'active' : '' }}" href="{{ route('IngresoEmpleado.create') }}">
              <i class="fas fa-camera mr-2"></i> Registrar Ingreso/Salida
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('IngresoEmpleado') ? 'active' : '' }}" href="{{ route('IngresoEmpleado.index') }}">
              <i class="fas fa-list mr-2"></i> Ver Registros
            </a>
          </li>
          <li class="nav-item" id="historico">
            <a class="nav-link {{ request()->is('Historico*') ? 'active' : '' }}" href="{{ route('Historico.create') }}">
              <i class="fas fa-history mr-2"></i> Histórico
            </a>
          </li>
        </ul>
      </div>
    </li>
    
    <li class="nav-item {{ request()->is('ReporteIngresos*') ? 'active' : '' }}" id="reportes">
      <a class="nav-link" data-toggle="collapse" href="#reports" aria-expanded="{{ request()->is('ReporteIngresos*') ? 'true' : 'false' }}" aria-controls="reports">
        <i class="fas fa-chart-bar menu-icon"></i>
        <span class="menu-title">Reportes</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->is('ReporteIngresos*') ? 'show' : '' }}" id="reports">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('ReporteIngresosDiarios*') ? 'active' : '' }}" href="{{ route('ReporteIngresosDiarios.index') }}">
              <i class="fas fa-calendar-day mr-2"></i> Reportes Diarios
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('ReporteIngresosxEmpleado*') ? 'active' : '' }}" href="{{ route('ReporteIngresosxEmpleado.index') }}">
              <i class="fas fa-user-chart mr-2"></i> Por Empleado
            </a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>

<style>
  .sidebar {
    background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
    min-height: 100vh;
  }
  
  .sidebar .nav-item .nav-link {
    color: rgba(255, 255, 255, 0.8);
    padding: 12px 20px;
    margin: 5px 10px;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
  }
  
  .sidebar .nav-item .nav-link:hover {
    background: rgba(102, 126, 234, 0.2);
    color: white;
    transform: translateX(5px);
  }
  
  .sidebar .nav-item.active > .nav-link,
  .sidebar .nav-item .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  
  .sidebar .nav-item .nav-link .menu-icon {
    width: 25px;
    margin-right: 15px;
    font-size: 1.2rem;
  }
  
  .sidebar .nav-item .nav-link .menu-title {
    font-weight: 500;
    font-size: 0.95rem;
  }
  
  .sidebar .sub-menu {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    margin: 5px 10px;
    padding: 10px 0;
  }
  
  .sidebar .sub-menu .nav-link {
    padding: 8px 20px 8px 50px;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
  }
  
  .sidebar .sub-menu .nav-link:hover {
    background: rgba(102, 126, 234, 0.15);
    color: white;
  }
  
  .sidebar .sub-menu .nav-link.active {
    background: rgba(102, 126, 234, 0.3);
    color: white;
    border-left: 3px solid #667eea;
  }
  
  .nav-profile {
    padding: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 10px;
  }
  
  .menu-arrow {
    margin-left: auto;
    transition: transform 0.3s;
  }
  
  .nav-item[aria-expanded="true"] .menu-arrow {
    transform: rotate(180deg);
  }
</style>
