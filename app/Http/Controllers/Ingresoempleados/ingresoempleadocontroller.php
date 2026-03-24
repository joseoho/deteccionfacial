<?php

namespace App\Http\Controllers\Ingresoempleados;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\timemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ingresoempleadocontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Establecer zona horaria para la consulta
        Carbon::setLocale('es');
        
        $query = timemark::query();
        
        // Búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('cinumber', 'like', "%{$search}%");
            });
        }
        
        // Filtro por tipo
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }
        
        // Filtro por fecha - CORREGIDO para usar zona horaria
        if ($request->has('fecha') && !empty($request->fecha)) {
            $fecha = Carbon::parse($request->fecha, 'America/Caracas');
            $query->whereDate('created_at', $fecha->format('Y-m-d'));
        }
        
        $ingresos = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        return view('ingresoempleados.index', compact('ingresos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Usar zona horaria de Venezuela
        $fecha = Carbon::now('America/Caracas');
        $empleados = employee::get();
        $ingresos = timemark::orderBy('created_at', 'desc')->take(10)->get();
        return view('ingresoempleados.create', compact('empleados','fecha','ingresos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * Store a newly created resource in storage.
 */
/**
 * Verificar si ya existe un registro en el rango de tiempo permitido
 */
private function verificarRegistroExistente($cedula, $tipo, $hora)
{
    // Definir los rangos de tiempo para evitar registros duplicados
    $rangos = [
        'entrada_manana' => ['inicio' => '06:00', 'fin' => '09:30', 'tipo' => 'entrada'],
        'salida_mediodia' => ['inicio' => '11:30', 'fin' => '13:30', 'tipo' => 'salida'],
        'entrada_tarde' => ['inicio' => '13:31', 'fin' => '14:30', 'tipo' => 'entrada'],
        'salida_noche' => ['inicio' => '17:00', 'fin' => '23:59', 'tipo' => 'salida'],
    ];
    
    // Determinar en qué rango estamos
    $horaActual = $hora->format('H:i');
    $rangoActual = null;
    
    foreach ($rangos as $key => $rango) {
        if ($horaActual >= $rango['inicio'] && $horaActual <= $rango['fin']) {
            $rangoActual = $key;
            break;
        }
    }
    
    if (!$rangoActual) {
        return false;
    }
    
    // Obtener la fecha actual
    $fechaActual = $hora->format('Y-m-d');
    
    // Verificar si ya existe un registro en este rango horario hoy
    $existeRegistro = timemark::where('cinumber', $cedula)
        ->where('type', $tipo)
        ->whereDate('created_at', $fechaActual)
        ->whereTime('created_at', '>=', $rangos[$rangoActual]['inicio'])
        ->whereTime('created_at', '<=', $rangos[$rangoActual]['fin'])
        ->exists();
    
    return $existeRegistro;
}

/**
 * Store a newly created resource in storage (versión mejorada)
 */
public function store(Request $request)
{
    // Definir la variable de hora de Venezuela
    $nowVenezuela = Carbon::now('America/Caracas');
    
    // Determinar el tipo de registro según la hora
    $tipoRegistro = $this->determinarTipoRegistro($nowVenezuela);
    
    // Validar si la hora está dentro de los rangos permitidos
    if (!$tipoRegistro) {
        return back()->with('error', '❌ Hora no válida para registrar. Horarios permitidos: ' .
            '06:00-09:30 (ENTRADA), 11:30-13:30 (SALIDA), 13:31-14:30 (ENTRADA), 17:00 en adelante (SALIDA)');
    }
    
    // Verificar si ya existe un registro en este horario
    $cedula = $request->empleado_id;
    if ($this->verificarRegistroExistente($cedula, $tipoRegistro, $nowVenezuela)) {
        $mensajeTipo = ($tipoRegistro == 'entrada') ? 'entrada' : 'salida';
        return back()->with('error', "⚠️ Ya se registró una {$mensajeTipo} en este horario hoy. No se puede registrar nuevamente.");
    }
    
    // Crear estructura de carpetas con fecha de Venezuela
    $mes = $nowVenezuela->format('m');
    $anio = $nowVenezuela->format('Y');
    
    $baseDIR = public_path('uploads/' . $anio . '/' . $mes . "/");
    $relativePath = 'uploads/' . $anio . '/' . $mes . "/";

    if (!file_exists($baseDIR)) {
        mkdir($baseDIR, 0755, true);
    }

    $img = $request->get('data_url');
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $decodifica = base64_decode($img, true);
    
    $filename = Str::random(10) . '_' . $cedula . '_' . $nowVenezuela->timestamp . '.png';
    file_put_contents($baseDIR . $filename, $decodifica);
    
    $imagePath = $relativePath . $filename;
    
    if (employee::where('cinumber', $cedula)->exists()) {
        $seregistraempleado = new timemark();
        $seregistraempleado->cinumber = $cedula;
        $seregistraempleado->photourl = $imagePath;
        $seregistraempleado->type = $tipoRegistro;
        
        // Forzar las fechas con la hora de Venezuela
        $seregistraempleado->created_at = $nowVenezuela;
        $seregistraempleado->updated_at = $nowVenezuela;
        
        $seregistraempleado->save();
        
        // Mensaje según el tipo de registro
        $mensajeTipo = ($tipoRegistro == 'entrada') ? '✅ ENTRADA registrada' : '✅ SALIDA registrada';
        
        return back()->with('notification', "{$mensajeTipo} a las " . $nowVenezuela->format('h:i:s A'));
    }
    
    return back()->with('noexiste', '❌ Cédula no registrada, verifique');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ingreso = timemark::findOrFail($id);
        
        // Eliminar la imagen si existe
        if ($ingreso->photourl) {
            $imagePath = public_path($ingreso->photourl);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $ingreso->delete();
        
        return redirect()->route('IngresoEmpleado.index')
            ->with('success', 'Registro eliminado exitosamente');
    }

    /**
 * Determinar el tipo de registro basado en la hora
 */
private function determinarTipoRegistro($hora)
{
    // Obtener solo la hora y minutos en formato HH:MM
    $horaActual = $hora->format('H:i');
    
    // Definir los rangos de horarios
    // Ingreso mañana: 06:00 - 09:30
    if ($horaActual >= '06:00' && $horaActual <= '09:30') {
        return 'entrada';
    }
    
    // Salida mediodía: 11:30 - 13:30
    if ($horaActual >= '11:30' && $horaActual <= '13:30') {
        return 'salida';
    }
    
    // Ingreso tarde: 13:31 - 14:30
    if ($horaActual >= '13:31' && $horaActual <= '14:30') {
        return 'entrada';
    }
    
    // Salida noche: 17:00 en adelante
    if ($horaActual >= '17:00') {
        return 'salida';
    }
    
    // Si no está en ningún rango, retornar null o el tipo por defecto
    return null;
}
}