<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marcas';
    
    protected $fillable = ['nombre', 'activa'];
    
    protected $casts = ['activa' => 'boolean'];
    
    public $timestamps = false;

    public function productos()
    {
        return $this->hasMany(Producto::class, 'marca_id');
    }

    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }
}