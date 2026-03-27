<?php

namespace App\Exports;

use App\Models\timemark;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class HistoricoExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $ingresos;
    protected $cedula;
    protected $fi;
    protected $ff;

    public function __construct($ingresos, $cedula = null, $fi = null, $ff = null)
    {
        $this->ingresos = $ingresos;
        $this->cedula = $cedula;
        $this->fi = $fi;
        $this->ff = $ff;
    }

    public function collection()
    {
        return $this->ingresos;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cédula',
            'Fecha',
            'Hora',
            // 'Tipo',
            // 'Foto URL'
        ];
    }

    public function map($ingreso): array
    {
        return [
            $ingreso->id,
            $ingreso->cinumber,
            Carbon::parse($ingreso->created_at)->format('d/m/Y'),
            Carbon::parse($ingreso->created_at)->format('H:i:s'),
            // $ingreso->type == 'ingreso' ? 'ENTRADA' : ($ingreso->type == 'salida' ? 'SALIDA' : 'N/A'),
            // $ingreso->photourl ? asset($ingreso->photourl) : 'Sin foto'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}