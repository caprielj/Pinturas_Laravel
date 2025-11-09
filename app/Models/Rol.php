<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Rol
 * 
 * Representa los roles de usuario en el sistema.
 * Roles disponibles: Digitador, Cajero, Gerente
 */
class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;

    // RELACIONES

    /**
     * Un rol puede tener muchos usuarios
     */
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'rol_id');
    }
}