<?php

// Declaración del namespace donde se ubican todos los modelos
namespace App\Models;

// Permite usar factories para generar datos de prueba (testing/seeding)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Proporciona funcionalidades ORM (Object-Relational Mapping)
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Marca
 * 
 * Representa la tabla 'marcas' en la base de datos
 * Las marcas identifican al fabricante de los productos (ej: Sherwin-Williams, Comex, etc.)
 * 
 * Características:
 * - Maneja conversión automática del campo 'activa' a booleano (casting)
 * - Incluye un Query Scope para filtrar marcas activas
 * 
 * Relaciones:
 * - hasMany con Producto: Una marca tiene muchos productos
 */
class Marca extends Model
{
    // use HasFactory - Trait que habilita el uso de factories
    // Permite generar datos de prueba: Marca::factory()->create()
    use HasFactory;

    // $table - Especifica explícitamente el nombre de la tabla en la base de datoso
    // Esta propiedad asegura que se use la tabla 'marcas'
    protected $table = 'marcas';
    
    // $fillable - Define los campos que pueden ser asignados masivamente
    // Solo los campos listados aquí pueden ser asignados de esta forma
    protected $fillable = ['nombre', 'activa'];
    
    // $casts - Define conversiones automáticas de tipos de datos (Type Casting)
    protected $casts = ['activa' => 'boolean'];
    
    // $timestamps - Controla si Laravel maneja automáticamente created_at y updated_at
    // false = No usa timestamps automáticos
    // true (por defecto) = Laravel agrega/actualiza created_at y updated_at automáticamente
    // En este caso está en false porque la tabla no tiene estos campos
    public $timestamps = false;

    /**
     * Relación hasMany con Producto
     * 
     * Define que una marca puede tener muchos productos
     * Relación Uno a Muchos (1:N)
     * Permite acceder a los productos de una marca:
     */
    public function productos()
    {
        // hasMany() - Define una relación de uno a muchos
        // Producto::class - Modelo relacionado (clase Producto)?
        return $this->hasMany(Producto::class, 'marca_id');
    }

    /**
     * Los Query Scopes son métodos que encapsulan consultas comunes
     * Permiten reutilizar lógica de consultas de forma elegante
     */
    public function scopeActivas($query)
    {
        // where('activa', true) - Filtra solo las marcas donde activa = 1
        // El scope modifica la consulta y retorna el query builder
        return $query->where('activa', true);
    }
}