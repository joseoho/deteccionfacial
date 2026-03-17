<?php

namespace App\Http\Controllers\Reporteingresosdiarios;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\timemark;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Reporteingresosdiarios extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = employee::all();
        return view('ingresoempleados.vistareportediarios', compact('empleados'));
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
        $date = Carbon::now('America/Caracas');
        $fi = Carbon::parse($request->fecha_ini.' 00:00:00');
        $ff = Carbon::parse($request->fecha_fin.' 23:59:59');
        
        $ingresos = timemark::join('employee as e', 'e.cinumber', '=', 'timemark.cinumber')
            ->select('timemark.id', 'timemark.cinumber', 'timemark.created_at as timestamp', 'e.name', 'timemark.type', 'timemark.photourl')
            ->whereBetween('timemark.created_at', [$fi, $ff])
            ->orderBy('timemark.cinumber', 'asc')
            ->orderBy('timemark.created_at', 'asc')
            ->get();
        
        if ($ingresos->count() > 0) {
            return view('reportes.reporteingresosdiariosxempleado', compact('ingresos', 'date', 'fi', 'ff'));
        } else {
            return back()->with('noexiste', 'No se encontraron registros para el rango de fechas seleccionado.');
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
