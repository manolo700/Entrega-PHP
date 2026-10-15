<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditType;

class AuditTypeSeeder extends Seeder
{
    // datos iniciales para los tipos de auditoria
    public function run(): void
    {
        AuditType::create([
            'nombre_norma' => 'ISO 9001:2015 - Gestión de Calidad',
            'descripcion' => 'Evalúa la calidad de procesos, satisfacción del cliente y mejora continua de productos o servicios.',
        ]);

        AuditType::create([
            'nombre_norma' => 'ISO 14001:2015 - Gestión Ambiental',
            'descripcion' => 'Evalúa el impacto ambiental, manejo adecuado de residuos y reducción del consumo de recursos.',
        ]);

        AuditType::create([
            'nombre_norma' => 'ISO 27001:2022 - Seguridad de la Información',
            'descripcion' => 'Revisa políticas de contraseñas, control de accesos, respaldo de datos y protección contra ciberataques.',
        ]);

        AuditType::create([
            'nombre_norma' => 'ISO 22301:2019 - Continuidad del Negocio',
            'descripcion' => 'Evalúa planes de contingencia (DRP) y capacidad de recuperación ante caídas del sistema.',
        ]);
    }
}
