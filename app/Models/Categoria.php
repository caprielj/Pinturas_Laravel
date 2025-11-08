<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Categoria
 * 
 * Representa las categorías o tipos de productos.
 * 
 * Ejemplos:
 * - Pinturas de Interior
 * - Pinturas de Exterior
 * - Esmaltes
 * - Impermeabilizantes
 * - Accesorios
 * - Solventes
 * - Barnices
 */
class Categoria extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'categorias';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Esta tabla no tiene timestamps
    public $timestamps = false;

    // RELACIONES

    /**
     * Una categoría puede tener muchos productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }

    // MÉTODOS AUXILIARES

    /**
     * Cuenta cuántos productos tiene esta categoría
     */
    public function cantidadProductos()
    {
        return $this->productos()->count();
    }

    /**
     * Obtiene solo los productos activos de esta categoría
     */
    public function productosActivos()
    {
        return $this->productos()->where('activo', true);
    }
}