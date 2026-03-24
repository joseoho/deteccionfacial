<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    
    /**
     * Mutator para created_at - ANTES de guardar en BD
     */
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = $value;
    }
    
    /**
     * Mutator para updated_at - ANTES de guardar en BD
     */
    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = $value;
    }
    
    /**
     * Accessor para created_at - DESPUÉS de leer de BD
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('America/Caracas');
    }
    
    /**
     * Accessor para updated_at - DESPUÉS de leer de BD
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('America/Caracas');
    }

}
