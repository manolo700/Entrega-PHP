<?php

namespace App\Http\Controllers;

use App\Models\Audit;

class DashboardController extends Controller
{
    
    public function index()
    {
        
        $conteos = Audit::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $pendientes  = (int) ($conteos['pendiente']  ?? 0);
        $enProceso   = (int) ($conteos['en_proceso'] ?? 0);
        $completadas = (int) ($conteos['completado'] ?? 0);
        $total       = $pendientes + $enProceso + $completadas;

        
        $pct = fn (int $cantidad): float => $total > 0 ? round($cantidad / $total * 100, 1) : 0;

        $porcentajePendiente  = $pct($pendientes);
        $porcentajeEnProceso  = $pct($enProceso);
        $porcentajeCompletado = $pct($completadas);

        $ultimaSemana = Audit::where('created_at', '>=', now()->subDays(7))->count();

        $recientes = Audit::latest()->take(5)->get();

        return view('dashboard', compact(
            'total',
            'pendientes',
            'enProceso',
            'completadas',
            'porcentajePendiente',
            'porcentajeEnProceso',
            'porcentajeCompletado',
            'ultimaSemana',
            'recientes'
        ));
    }
}