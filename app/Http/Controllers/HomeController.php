<?php

namespace App\Http\Controllers;

use App\Models\employee;
use App\Models\timemark;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home dashboard.
     */
    public function index()
    {
        $totalEmpleados = employee::count();
        $totalRegistros = timemark::count();
        $registrosHoy = timemark::whereDate('created_at', today())->count();
        $ultimosRegistros = timemark::with('employee')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('home', compact('totalEmpleados', 'totalRegistros', 'registrosHoy', 'ultimosRegistros'));
    }
}

