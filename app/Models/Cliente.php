<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Cliente
 * 
 * Este modelo representa a los clientes de la tienda de pinturas.
 * Los clientes pueden registrarse para recibir promociones y realizar compras.
 * 
 * Campos principales:
 * - nombre: Nombre completo del cliente
 * - nit: Número de Identificación Tributaria (único)
 * - email: Correo electrónico (único, usado para login)
 * - password_hash: Contraseña encriptada
 * - opt_in_promos: Si acepta recibir promociones
 * - verificado: Si el email ha sido verificado
 * - telefono: Número de contacto
 * - direccion: Dirección física
 * - gps_lat, gps_lng: Coordenadas GPS de la dirección
 */
class Cliente extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'clientes';

    /**
     * Los atributos que se pueden asignar masivamente.
     * Esto permite usar Cliente::create() o $cliente->fill() con estos campos.
     */
    protected $fillable = [
        'nombre',
        'nit',
        'email',
        'password_hash',
        'opt_in_promos',
        'verificado',
        'telefono',
        'direccion',
        'gps_lat',
        'gps_lng',
    ];

    /**
     * Los atributos que deben ser ocultados en arrays/JSON.
     * Esto protege información sensible como contraseñas.
     */
    protected $hidden = [
        'password_hash',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * 
     * - opt_in_promos: Se convierte a booleano (true/false)
     * - verificado: Se convierte a booleano
     * - gps_lat, gps_lng: Se convierten a float para cálculos de distancia
     * - creado_en: Se convierte a objeto Carbon (para manejo de fechas)
     */
    protected $casts = [
        'opt_in_promos' => 'boolean',
        'verificado' => 'boolean',
        'gps_lat' => 'float',
        'gps_lng' => 'float',
        'creado_en' => 'datetime',
    ];

    /**
     * Laravel por defecto usa 'created_at' y 'updated_at'
     * pero nuestra tabla usa 'creado_en', así que lo especificamos.
     */
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null; // Esta tabla no tiene updated_at

    /**
     * RELACIONES
     * 
     * Define las relaciones con otras tablas de la base de datos.
     */

    /**
     * Un cliente puede tener muchas facturas.
     * Relación uno a muchos (1:N)
     */
    public function facturas()
    {
        return $this->hasMany(Factura::class, 'cliente_id');
    }

    /**
     * Un cliente puede tener muchas cotizaciones.
     * Relación uno a muchos (1:N)
     */
    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class, 'cliente_id');
    }

    /**
     * Un cliente puede tener muchos carritos de compra.
     * Relación uno a muchos (1:N)
     */
    public function carritos()
    {
        return $this->hasMany(Carrito::class, 'cliente_id');
    }

    /**
     * MÉTODOS AUXILIARES
     * 
     * Métodos útiles para trabajar con el modelo.
     */

    /**
     * Obtiene el nombre completo del cliente.
     * Este es un accessor que se puede usar como: $cliente->nombre_completo
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombre;
    }

    /**
     * Verifica si el cliente ha sido verificado.
     * @return bool
     */
    public function estaVerificado()
    {
        return $this->verificado === true;
    }

    /**
     * Verifica si el cliente acepta promociones.
     * @return bool
     */
    public function aceptaPromociones()
    {
        return $this->opt_in_promos === true;
    }

    /**
     * Obtiene las coordenadas GPS como un array.
     * Útil para mostrar en mapas.
     * @return array|null
     */
    public function getCoordenadas()
    {
        if ($this->gps_lat && $this->gps_lng) {
            return [
                'lat' => $this->gps_lat,
                'lng' => $this->gps_lng,
            ];
        }
        return null;
    }

    /**
     * Scope para filtrar solo clientes verificados.
     * Uso: Cliente::verificados()->get()
     */
    public function scopeVerificados($query)
    {
        return $query->where('verificado', true);
    }

    /**
     * Scope para filtrar solo clientes que aceptan promociones.
     * Uso: Cliente::conPromociones()->get()
     */
    public function scopeConPromociones($query)
    {
        return $query->where('opt_in_promos', true);
    }
}
