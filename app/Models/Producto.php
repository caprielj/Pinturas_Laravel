<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Producto
 * 
 * Representa los productos que se venden en la tienda (pinturas, solventes, accesorios, barnices).
 * 
 * Tipos de productos:
 * 1. Accesorios: Brochas, rodillos, bandejas, espátulas (por unidad)
 * 2. Solventes: Aguarrás, solvente limpiador (medidas en galones)
 * 3. Pinturas: Base agua, base aceite (medidas en galones, con color específico)
 * 4. Barnices: Sintético, acrílico (medidas en galones)
 */
class Producto extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'productos';

    // Campos que se pueden asignar masivamente
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

    // Conversión de tipos de datos
    protected $casts = [
        'duracion_anios' => 'integer',
        'extension_m2' => 'float',
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // RELACIONES

    /**
     * Un producto pertenece a una categoría
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Un producto pertenece a una marca
     */
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    /**
     * Un producto puede tener muchas presentaciones (relación muchos a muchos)
     * A través de la tabla intermedia 'productopresentacion'
     */
    public function presentaciones()
    {
        return $this->belongsToMany(
            Presentacion::class,
            'productopresentacion',
            'producto_id',
            'presentacion_id'
        )->withPivot('id', 'activo');
    }

    /**
     * Un producto puede tener muchos registros de inventario
     */
    public function inventarios()
    {
        return $this->hasManyThrough(
            InventarioSucursal::class,
            ProductoPresentacion::class,
            'producto_id',
            'producto_presentacion_id',
            'id',
            'id'
        );
    }

    // SCOPES

    /**
     * Scope para obtener solo productos activos
     * Uso: Producto::activos()->get()
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para filtrar por categoría
     * Uso: Producto::porCategoria(1)->get()
     */
    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    /**
     * Scope para filtrar por marca
     * Uso: Producto::porMarca(1)->get()
     */
    public function scopePorMarca($query, $marcaId)
    {
        return $query->where('marca_id', $marcaId);
    }

    // MÉTODOS AUXILIARES

    /**
     * Verifica si el producto está activo
     */
    public function estaActivo()
    {
        return $this->activo === true;
    }

    /**
     * Verifica si el producto es una pintura o barniz
     * (estos tienen información de duración y extensión)
     */
    public function tieneDuracionYExtension()
    {
        return $this->duracion_anios !== null && $this->extension_m2 !== null;
    }

    /**
     * Obtiene el nombre completo del producto
     * Ejemplo: "Pintura Sherwin Williams Blanco Mate"
     */
    public function getNombreCompletoAttribute()
    {
        $nombre = $this->descripcion;
        
        if ($this->marca) {
            $nombre = $this->marca->nombre . ' - ' . $nombre;
        }
        
        if ($this->color) {
            $nombre .= ' (' . $this->color . ')';
        }
        
        return $nombre;
    }
}