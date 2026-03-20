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
        
        // Filtro por fecha
        if ($request->has('fecha') && !empty($request->fecha)) {
            $fecha = Carbon::parse($request->fecha, 'America/Caracas');
            $query->whereDate('created_at', $fecha);
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
    public function store(Request $request)
    {
        // Usar zona horaria de Venezuela
        $now = Carbon::now('America/Caracas');
        
        // Obtener el mes actual para organizar las carpetas
        $mes = $now->format('m');
        $anio = $now->format('Y');
        
        // Crear estructura de carpetas: uploads/2026/03/
        $baseDIR = public_path('uploads/' . $anio . '/' . $mes . "/");
        $relativePath = 'uploads/' . $anio . '/' . $mes . "/";

        // Crear directorio si no existe
        if (!file_exists($baseDIR)) {
            mkdir($baseDIR, 0755, true);
        }

        $cedula = $request->empleado_id;
        $img = $request->get('data_url');
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $decodifica = base64_decode($img, true);
        
        // Generar nombre único para la imagen
        $filename = Str::random(10) . '_' . $cedula . '_' . $now->timestamp . '.png';
        
        // Guardar la imagen
        file_put_contents($baseDIR . $filename, $decodifica);
        
        // Guardar SOLO la ruta relativa
        $imagePath = $relativePath . $filename;
        
        // Verificar si el empleado existe
        if (employee::where('cinumber', $cedula)->exists()) {
            $seregistraempleado = new timemark();
            $seregistraempleado->cinumber = $request->input('empleado_id');
            $seregistraempleado->photourl = $imagePath;
            $seregistraempleado->type = 'ingreso';
            
            // Forzar la fecha/hora de creación
            $seregistraempleado->created_at = $now;
            $seregistraempleado->updated_at = $now;
            
            $seregistraempleado->save();
            
            return back()->with('notification', 'Registro exitoso - ' . $now->format('d/m/Y h:i:s A'));
        }
        
        return back()->with('noexiste', 'Cédula no registrada, verifique');

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
}