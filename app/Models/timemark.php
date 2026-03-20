<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class timemark extends Model
{
   Protected $primaryKey = "id";
    protected $table ='timemark';
    protected $fillable = [
        //'id',
        'cinumber',
        'photourl',
        'type',
        'confidence',
  
    ];

    /**
     * Relación: Una marca de tiempo pertenece a un empleado
     */
    public function employee()
    {
        return $this->belongsTo(employee::class, 'cinumber', 'cinumber');
    }

    // Campos de fecha que deben ser convertidos a instancias de Carbon
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    
    // Accessor para created_at
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->timezone('America/Caracas');
    }
    
    // Accessor para updated_at
    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->timezone('America/Caracas');
    }


}
