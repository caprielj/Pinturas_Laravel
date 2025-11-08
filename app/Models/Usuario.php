<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Modelo Usuario
 * 
 * Representa a los empleados del sistema con diferentes roles.
 * 
 * Perfiles de usuario:
 * - Digitador: Alimenta el sistema con datos
 * - Cajero: Solo puede cobrar (autorizar ventas)
 * - Gerente: Puede ver reportes
 */
class Usuario extends Authenticatable
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'usuarios';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'dpi',
        'email',
        'password_hash',
        'rol_id',
        'sucursal_id',
        'activo',
    ];

    // Campos ocultos al serializar
    protected $hidden = [
        'password_hash',
    ];

    // Conversión de tipos de datos
    protected $casts = [
        'activo' => 'boolean',
        'creado_en' => 'datetime',
    ];

    // Laravel usa 'created_at' por defecto, pero nuestra tabla usa 'creado_en'
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    /**
     * Obtiene el nombre del campo de contraseña para autenticación
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // RELACIONES

    /**
     * Un usuario pertenece a un rol
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    /**
     * Un usuario pertenece a una sucursal
     */
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    /**
     * Un usuario puede crear muchas facturas
     */
    public function facturas()
    {
        return $this->hasMany(Factura::class, 'usuario_id');
    }

    /**
     * Un usuario puede crear muchas cotizaciones
     */
    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class, 'usuario_id');
    }

    /**
     * Un usuario puede crear muchas órdenes de compra
     */
    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompra::class, 'usuario_id');
    }

    // SCOPES

    /**
     * Scope para obtener solo usuarios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para filtrar por rol
     */
    public function scopePorRol($query, $rolId)
    {
        return $query->where('rol_id', $rolId);
    }

    /**
     * Scope para filtrar por sucursal
     */
    public function scopePorSucursal($query, $sucursalId)
    {
        return $query->where('sucursal_id', $sucursalId);
    }

    // MÉTODOS AUXILIARES

    /**
     * Verifica si el usuario está activo
     */
    public function estaActivo()
    {
        return $this->activo === true;
    }

    /**
     * Verifica si el usuario es digitador
     */
    public function esDigitador()
    {
        return $this->rol && $this->rol->nombre === 'Digitador';
    }

    /**
     * Verifica si el usuario es cajero
     */
    public function esCajero()
    {
        return $this->rol && $this->rol->nombre === 'Cajero';
    }

    /**
     * Verifica si el usuario es gerente
     */
    public function esGerente()
    {
        return $this->rol && $this->rol->nombre === 'Gerente';
    }
}