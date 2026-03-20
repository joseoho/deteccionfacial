<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class employeecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        set_time_limit(300);
        
        $query = employee::query();
        
        // Búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('cinumber', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }
        
        // Filtro por estado
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $empleados = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cinumber' => 'required|unique:employee,cinumber|numeric',
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'status' => 'required|in:ACTIVO,VACACIONES,REPOSO,INACTIVO',
            'note' => 'nullable|string',
            'reference_photo' => 'nullable|string',
        ]);

        // Verificar si ya existe un empleado con esa cédula
        if (employee::where('cinumber', $request->cinumber)->exists()) {
            return back()->withInput()->with('error', 'Ya existe un empleado con esta cédula.');
        }

        $empleado = new employee();
        $empleado->cinumber = $request->cinumber;
        $empleado->name = $request->name;
        $empleado->role = $request->role;
        $empleado->status = $request->status;
        $empleado->note = $request->note;
        $empleado->reference_photo_url = null;

        // Procesar foto de referencia si existe
        if ($request->has('reference_photo') && !empty($request->reference_photo)) {
            $photoUrl = $this->savePhoto($request->reference_photo, $request->cinumber);
            $empleado->reference_photo_url = $photoUrl;
        }

        $empleado->save();

        return redirect()->route('Empleado.index')
            ->with('success', 'Empleado creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $empleado = employee::with(['timemarks', 'ingresos'])->findOrFail($id);
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $empleado = employee::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empleado = employee::findOrFail($id);

        $request->validate([
            'cinumber' => 'required|numeric|unique:employee,cinumber,' . $id,
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'status' => 'required|in:ACTIVO,VACACIONES,REPOSO,INACTIVO',
            'note' => 'nullable|string',
            'reference_photo' => 'nullable|string',
        ]);

        $empleado->cinumber = $request->cinumber;
        $empleado->name = $request->name;
        $empleado->role = $request->role;
        $empleado->status = $request->status;
        $empleado->note = $request->note;
        $empleado->reference_photo_url = $empleado->reference_photo_url; // Mantener la foto actual por defecto

        // Procesar nueva foto de referencia si existe
        if ($request->has('reference_photo') && !empty($request->reference_photo)) {
            // Eliminar foto anterior si existe
            if ($empleado->reference_photo_url) {
                $oldPhotoPath = str_replace(url('/'), '', $empleado->reference_photo_url);
                if (Storage::disk('public')->exists($oldPhotoPath)) {
                    Storage::disk('public')->delete($oldPhotoPath);
                }
            }
            
            $photoUrl = $this->savePhoto($request->reference_photo, $request->cinumber);
            $empleado->reference_photo_url = $photoUrl;
        }

        $empleado->save();

        return redirect()->route('Empleado.index')
            ->with('success', 'Empleado actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleado = employee::findOrFail($id);

        // Eliminar foto de referencia si existe
        if ($empleado->reference_photo_url) {
            $photoPath = str_replace(url('/'), '', $empleado->reference_photo_url);
            if (Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }
        }

        $empleado->delete();

        return redirect()->route('Empleado.index')
            ->with('success', 'Empleado eliminado exitosamente.');
    }

    /**
     * Guardar foto de referencia desde base64
     */
    private function savePhoto($base64Image, $cinumber)
    {
            $baseDIR = public_path('uploads/employees/' . date("Y/m", time()) . "/");
    $relativePath = 'uploads/employees/' . date("Y/m", time()) . "/";

    if (!file_exists($baseDIR)) {
        mkdir($baseDIR, 0755, true);
    }

    $img = str_replace('data:image/png;base64,', '', $base64Image);
    $img = str_replace(' ', '+', $img);
    $decodifica = base64_decode($img, true);
    $extension = "png";
    $filename = Str::random(10) . '_' . $cinumber . '.' . $extension;
    
    file_put_contents($baseDIR . $filename, $decodifica);
    
    // Guardar SOLO la ruta relativa, no la URL completa
    return $relativePath . $filename;
}
}