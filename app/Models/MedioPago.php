<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedioPago extends Model
{
    use HasFactory;

    protected $table = 'mediospago';
    
    protected $fillable = ['nombre', 'activo'];
    
    protected $casts = ['activo' => 'boolean'];
    
    public $timestamps = false;

    // Relación comentada temporalmente - se activará en Fase 2
    // public function pagos()
    // {
    //     return $this->hasMany(Pago::class, 'medio_pago_id');
    // }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}