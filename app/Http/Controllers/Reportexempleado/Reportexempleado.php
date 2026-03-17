<?php

namespace App\Http\Controllers\Reportexempleado;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\timemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Reportexempleado extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = employee::all();
        return view('ingresoempleados.vistareporte', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        set_time_limit(300);
        $empleados = employee::all();
        
        $fi = Carbon::parse($request->fecha_ini.' 00:00:00');
        $ff = Carbon::parse($request->fecha_fin.' 23:59:59');
        $cedula = $request->empleado_id;
    
        $ingresos = timemark::where('cinumber', $cedula)
            ->whereBetween('created_at', [$fi, $ff])
            ->orderBy('created_at', 'asc')
            ->get();
        
        if ($ingresos->count() > 0) {
            // Si tienes instalado dompdf o similar, descomenta estas líneas
            // $pdf = \PDF::loadView('reportes.reporteingresosxempleado', compact('ingresos', 'empleados'));
            // return $pdf->stream();
            
            // Por ahora retornamos la vista directamente
            return view('reportes.reporteingresosxempleado', compact('ingresos', 'empleados'));
        } else {
            return back()->with('noexiste', 'No se encontraron registros para el empleado y rango de fechas seleccionado.');
        }
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
        //
    }
}
