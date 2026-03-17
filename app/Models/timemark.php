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

}
