<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Registra y ejecuta los seeders de la aplicación.
     */
    public function run(): void
    {
        $this->call([
            AuditSeeder::class,
            AuditTypeSeeder::class,
        ]);
    }
}
