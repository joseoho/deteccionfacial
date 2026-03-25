<?php

namespace App\Http\Controllers\Historico;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\timemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HistoricoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        set_time_limit(300);
        $empleados = employee::get();
        return view('historico.create', compact('empleados'));  
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
        
        // Validar los datos de entrada
        $request->validate([
            'empleado_id' => 'required|string',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_ini',
        ]);
        
        $cedula = $request->empleado_id;
        $fi = Carbon::parse($request->fecha_ini . ' 00:00:00', 'America/Caracas');
        $ff = Carbon::parse($request->fecha_fin . ' 23:59:59', 'America/Caracas');
        
        // Consulta base
        $query = timemark::where('cinumber', $cedula)
            ->whereBetween('created_at', [$fi, $ff]);
        
        // Aplicar filtros adicionales si existen
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('cinumber', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }
        
        // Ordenar y paginar
        $ingresos = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();
        
        if ($ingresos->count() > 0) {
            return view('historico.index', compact('ingresos', 'cedula', 'fi', 'ff'));
        } else {
            return redirect()->route('Historico.index')
                ->with('noexiste', 'No se encontraron registros para el rango de fechas seleccionado.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ingreso = timemark::with('employee')->findOrFail($id);
        return view('historico.show', compact('ingreso'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ingreso = timemark::findOrFail($id);
        return view('historico.edit', compact('ingreso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'hora' => 'required|date',
        ]);

        $hora = timemark::findOrFail($id);
        $hora->created_at = $request->input('hora');
        $hora->save();
        
        if($hora){
            return redirect()->route('Historico.show', $id)->with('success', 'Registro actualizado exitosamente.');
        }
        return redirect()->route('Historico.show', $id)->with('error', 'Error al actualizar el registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ingreso = timemark::findOrFail($id);
        $ingreso->delete();
        return redirect()->route('Historico.index')->with('success', 'Registro eliminado exitosamente.'); 
    }
}
