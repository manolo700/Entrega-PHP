<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditType extends Model
{
    use HasFactory;

    // tabla en la base de datos
    protected $table = 'audit_types';

    // campos asignables
    protected $fillable = [
        'nombre_norma',
        'descripcion',
    ];
}
