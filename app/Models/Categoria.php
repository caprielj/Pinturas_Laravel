<?php

// Declaración del namespace donde se ubican todos los modelos
namespace App\Models;

// Permite usar factories para generar datos de prueba (testing/seeding)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Importación de la clase base Model de Eloquent
// Proporciona funcionalidades ORM (Object-Relational Mapping)
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Categoria
 * 
 * Representa la tabla 'categorias' en la base de datos
 * Relaciones:
 * - hasMany con Producto: Una categoría tiene muchos productos
 */
class Categoria extends Model
{
    // Permite generar datos de prueba: Categoria::factory()->create()
    use HasFactory;

    // $table - Especifica explícitamente el nombre de la tabla en la base de datos
   // protected es un modificador de acceso que controla quien puede acceder a una propiedad o método de una clase.
    protected $table = 'categorias';
    
    // $fillable - Define los campos que pueden ser asignados masivamente
    // Ejemplo: Categoria::create(['nombre' => 'Pinturas', 'descripcion' => 'Desc'])
    protected $fillable = ['nombre', 'descripcion'];
    
    // $timestamps - Controla si Laravel maneja automáticamente created_at y updated_at
    // false = No usa timestamps automáticos
    // true (por defecto) = Laravel agrega/actualiza created_at y updated_at automáticamente
    // En este caso está en false porque la tabla no tiene estos campos
    public $timestamps = false;

    /**
     * Relación hasMany con Producto
     * 
     * Define que una categoría puede tener muchos productos
     * Relación Uno a Muchos (1:N)
     */
    public function productos()
    {
        // hasMany() - Define una relación de uno a muchos
        // Producto::class - Modelo relacionado (clase Producto)
        // 'categoria_id' - Clave foránea en la tabla productos que apunta a esta categoría
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}