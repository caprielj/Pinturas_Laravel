<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';
    
    protected $fillable = [
        'nombre',
        'dpi',
        'email',
        'password_hash',
        'rol_id',
        'sucursal_id',
        'activo',
    ];
    
    protected $hidden = ['password_hash'];
    
    protected $casts = [
        'activo' => 'boolean',
        'creado_en' => 'datetime',
    ];
    
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    // Relaciones comentadas - se activarán en Fase 2
    // public function facturas()
    // {
    //     return $this->hasMany(Factura::class, 'usuario_id');
    // }

    // public function cotizaciones()
    // {
    //     return $this->hasMany(Cotizacion::class, 'usuario_id');
    // }

    // public function ordenesCompra()
    // {
    //     return $this->hasMany(OrdenCompra::class, 'usuario_id');
    // }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}