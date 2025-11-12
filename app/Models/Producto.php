<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Producto
 * Representa los productos (pinturas) en la base de datos
 */
class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    // $fillable: Campos que se pueden llenar con create() o update()
    protected $fillable = [
        'categoria_id',     // FK a categorias
        'marca_id',         // FK a marcas
        'codigo_sku',       // Código único del producto
        'descripcion',      // Nombre/descripción
        'tamano',          // Ej: "1L", "4L"
        'duracion_anios',  // Vida útil
        'extension_m2',    // Rendimiento en metros cuadrados
        'color',
        'imagen',          // Ruta de la imagen del producto
        'activo',          // 1 = activo, 0 = inactivo
    ];

    // $casts: Convierte tipos de datos automáticamente
    protected $casts = [
        'duracion_anios' => 'integer',  // Convierte a número entero
        'extension_m2' => 'float',      // Convierte a decimal
        'activo' => 'boolean',          // Convierte 0/1 a false/true
    ];

    // RELACIONES (solo Fase 1)
    
    // belongsTo: Un producto PERTENECE a una categoría
    // Uso: $producto->categoria->nombre
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // belongsTo: Un producto PERTENECE a una marca
    // Uso: $producto->marca->nombre
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }
}