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
            $fecha = Carbon::parse($request->fecha);
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
       $baseDIR = public_path('uploads/' . date("m", time()) . "/");
       $baseURL = url('uploads/' . date("m", time()) . "/");
  
  if (!file_exists($baseDIR)) {
    mkdir($baseDIR, 0755, true);
  }


             $cedula=$request->empleado_id;
             $img    = $request->get('data_url');
             $img    = str_replace('data:image/png;base64,', '', $img);
             $img    = str_replace(' ', '+', $img);
             $decodifica = base64_decode($img,true);
             $extension  = "png";
             $filename = Str::random(10).$cedula .'.'.$extension;
             $path    = $baseDIR;
             $success = file_put_contents($baseDIR .$filename,$decodifica);
             $imageURL = $baseURL . $filename;
                            if (employee::where('cinumber', $cedula)->exists()) {
                                $seregistraempleado = new timemark();
                                $seregistraempleado->cinumber = $request->input('empleado_id');
                                $seregistraempleado->photourl = ltrim($imageURL, '.');
                                $seregistraempleado->save();
                                return back()->with('notification', 'Registrado');
                             }
                            
                                 return back()->with('noexiste', 'cedula no registrada, verifique');//buenoi
                            
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
