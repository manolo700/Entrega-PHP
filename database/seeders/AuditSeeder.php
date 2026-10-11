<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Audit;

class AuditSeeder extends Seeder
{
    /**
     * Ejecuta la inserción de registros iniciales de prueba en la tabla 'audits'.
     */
    public function run(): void
    {
        Audit::create([
            'titulo' => 'Auditoría de Seguridad de Redes',
            'descripcion' => 'Revisión periódica de políticas de firewall y puertos abiertos.',
            'estado' => 'completado',
        ]);

        Audit::create([
            'titulo' => 'Inventario de Equipos y Servidores',
            'descripcion' => 'Verificación del estado físico y licencias en el centro de cómputo.',
            'estado' => 'en_proceso',
        ]);

        Audit::create([
            'titulo' => 'Optimización de Consultas MySQL',
            'descripcion' => 'Análisis de índices y tiempos de respuesta en la base de datos.',
            'estado' => 'pendiente',
        ]);
    }
}
