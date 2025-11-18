<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Representa los usuarios del sistema (empleados con acceso al sistema)
// Extiende Authenticatable: Permite autenticación (login/logout)
class Usuario extends Authenticatable
{
    use HasFactory;

    // protected: Accesible solo dentro de la clase y clases heredadas
    // $table: Nombre de la tabla en BD
    protected $table = 'usuarios';
    
    // protected: Control de seguridad para asignación masiva
    // $fillable: Campos permitidos al crear/actualizar
    protected $fillable = [
        'nombre',         // Nombre completo del usuario
        'dpi',            // DPI (Documento Personal de Identificación)
        'email',          // Correo electrónico para login
        'password_hash',  // Contraseña encriptada
        'rol_id',         // FK: Relación con tabla roles
        'sucursal_id',    // FK: Sucursal asignada al usuario
        'activo',         // Si el usuario puede acceder al sistema
    ];
    
    // protected: Oculta campos en respuestas JSON/API
    // $hidden: Campos que NO se muestran al serializar el modelo
    // Protege la contraseña para que no se exponga en APIs
    protected $hidden = ['password_hash'];
    
    // protected: Conversiones automáticas de tipos
    // $casts: Transforma datos entre BD y PHP
    protected $casts = [
        'activo' => 'boolean',     // Convierte 0/1 a false/true
        'creado_en' => 'datetime', // Convierte string a objeto Carbon (fechas)
    ];
    
    // const: Personaliza nombres de columnas de timestamps
    // Laravel busca created_at por defecto, aquí usamos 'creado_en'
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null; // No usamos updated_at

    // public: Método accesible desde cualquier lugar
    // Requerido por Authenticatable para autenticación
    // Indica qué campo contiene la contraseña para validar login
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // Especifica el campo que se usa como identificador para login
    // Por defecto Laravel busca 'email', aquí confirmamos que usamos 'email'
    public function getAuthIdentifierName()
    {
        return 'email';
    }

    // Relación belongsTo: Un usuario PERTENECE a un Rol
    // Uso: $usuario->rol->nombre (Ej: "Administrador", "Cajero")
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    // Relación belongsTo: Un usuario PERTENECE a una Sucursal
    // Uso: $usuario->sucursal->nombre (Ej: "Sucursal Centro")
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    // Query Scope: Filtra solo usuarios activos
    // Uso: Usuario::activos()->get()
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}