<?php

namespace App\Exports;

use App\Models\timemark;
use App\Models\employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class HistoricoAgrupadoExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $ingresos;
    protected $fi;
    protected $ff;

    public function __construct($ingresos, $fi = null, $ff = null)
    {
        $this->ingresos = $ingresos;
        $this->fi = $fi;
        $this->ff = $ff;

                Carbon::setLocale('es');

    }

    /**
     * Agrupar los registros por fecha y cédula
     */
    public function collection()
    {
        $agrupados = [];
        
        foreach ($this->ingresos as $ingreso) {
            $fecha = Carbon::parse($ingreso->created_at)->format('Y-m-d');
            $cedula = $ingreso->cinumber;
            $key = $fecha . '_' . $cedula;
            
            if (!isset($agrupados[$key])) {
                // Buscar nombre del empleado
                $empleado = employee::where('cinumber', $cedula)->first();
                
                $agrupados[$key] = (object)[
                    'fecha' => $fecha,
                    'dia_semana' => Carbon::parse($ingreso->created_at)->translatedFormat('l'), // Nombre del día completo
                    'dia_semana_corto' => Carbon::parse($ingreso->created_at)->translatedFormat('D'), // Nombre del día corto
                    'cedula' => $cedula,
                    'nombre' => $empleado ? $empleado->name : 'No encontrado',
                    'horas' => [], // Array para almacenar solo las horas
                ];
            }
            
            // Solo guardar la hora sin el tipo
            $hora = Carbon::parse($ingreso->created_at)->format('H:i:s');
            $agrupados[$key]->horas[] = $hora;
        }
        
        // Ordenar las horas dentro de cada grupo cronológicamente
        foreach ($agrupados as $key => $grupo) {
            sort($grupo->horas);
        }
        
        // Ordenar por fecha
        ksort($agrupados);
        
        // Convertir a colección
        return collect(array_values($agrupados));
    }

    /**
     * Headings del Excel
     */
    public function headings(): array
    {
        return [
            'Día',
            'Cédula',
            'Nombre Empleado',
            'Horario Registrado',
            'Total',
        ];
    }

    /**
     * Mapear los datos para cada fila
     */
    public function map($row): array
    {
        // Unir horas con espacio
        $horas = !empty($row->horas) ? implode(' ', $row->horas) : '---';
        $total = count($row->horas);
        
        return [
            $row->dia_semana, // Mostrar nombre completo del día
            $row->cedula,
            $row->nombre,
            $horas,
            $total,
        ];
    }

    /**
     * Estilos para el Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Estilo para los encabezados
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        
        // Estilo para la columna de días
        $sheet->getStyle('A2:A' . ($sheet->getHighestRow()))->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        
        // Estilo para la columna de horas
        $sheet->getStyle('D2:D' . ($sheet->getHighestRow()))->applyFromArray([
            'font' => [
                'name' => 'Courier New',
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        
        // Estilo para el total
        $sheet->getStyle('E2:E' . ($sheet->getHighestRow()))->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        
        // Ancho de columnas
        $sheet->getColumnDimension('A')->setWidth(20);  // Día
        $sheet->getColumnDimension('B')->setWidth(15);  // Cédula
        $sheet->getColumnDimension('C')->setWidth(30);  // Nombre
        $sheet->getColumnDimension('D')->setWidth(35);  // Horario
        $sheet->getColumnDimension('E')->setWidth(10);  // Total
        
        return [];
    }

    /**
     * Título de la hoja
     */
    public function title(): string
    {
        return 'Reporte de Asistencia';
    }
}