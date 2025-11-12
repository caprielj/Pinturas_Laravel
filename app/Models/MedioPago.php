<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Representa los métodos de pago (Efectivo, Tarjeta, Transferencia, etc.)
class MedioPago extends Model
{
    use HasFactory;

    protected $table = 'mediospago'; // Nombre de la tabla en BD
    
    protected $fillable = [
        'nombre',  // Ej: "Efectivo", "Tarjeta de Crédito"
        'activo'   // Si el medio de pago está habilitado
    ];
    
    protected $casts = [
        'activo' => 'boolean'  // Convierte 0/1 a false/true automáticamente
    ];
    
    public $timestamps = false; // No usa created_at ni updated_at

    // Query Scope: Filtra solo medios de pago activos
    // Uso: MedioPago::activos()->get()
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}