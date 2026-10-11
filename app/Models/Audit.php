<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo en la base de datos.
     *
     * @var string
     */
    protected $table = 'audits';

    /**
     * Los atributos que se pueden asignar de manera masiva (Mass Assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
    ];
}
