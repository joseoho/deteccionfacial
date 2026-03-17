<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ingresoempleado extends Model
{
    Protected $primaryKey = "id";
    //protected $table ='clientes';
    protected $fillable = [
        'id',
        'cinumber',
        'photourl',
    ];

    /**
     * Relación: Un ingreso pertenece a un empleado
     */
    public function employee()
    {
        return $this->belongsTo(employee::class, 'cinumber', 'cinumber');
    }
}
