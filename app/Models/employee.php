<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    Protected $primaryKey = "id";
    protected $table ='employee';
    protected $fillable = [
        
        'cinumber',
        'name',
        'role',
        'note',
        'status',
        'reference_photo_url',
        'rekognition_face_id',
    ];

    /**
     * Relación: Un empleado tiene muchas marcas de tiempo
     */
    public function timemarks()
    {
        return $this->hasMany(timemark::class, 'cinumber', 'cinumber');
    }

    /**
     * Relación: Un empleado tiene muchos ingresos
     */
    public function ingresos()
    {
        return $this->hasMany(ingresoempleado::class, 'cinumber', 'cinumber');
    }
}
