<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'marca_id',
        'codigo_sku',
        'descripcion',
        'tamano',
        'duracion_anios',
        'extension_m2',
        'color',
        'activo',
    ];

    protected $casts = [
        'duracion_anios' => 'integer',
        'extension_m2' => 'float',
        'activo' => 'boolean',
    ];

    // RELACIONES BÁSICAS (solo con tablas que existen en Fase 1)
    
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }
}