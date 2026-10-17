<?php

namespace App\Http\Controllers;

use App\Models\Audit;

class DashboardController extends Controller
{
    
    public function index()
    {
        
        $counts = Audit::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $pending    = (int) ($counts['pendiente']  ?? 0);
        $inProgress = (int) ($counts['en_proceso'] ?? 0);
        $completed  = (int) ($counts['completado'] ?? 0);
        $total      = $pending + $inProgress + $completed;

        
        $pct = fn (int $amount): float => $total > 0 ? round($amount / $total * 100, 1) : 0;

        $pendingPercentage    = $pct($pending);
        $inProgressPercentage = $pct($inProgress);
        $completedPercentage  = $pct($completed);

        $lastWeek = Audit::where('created_at', '>=', now()->subDays(7))->count();

        $recentAudits = Audit::latest()->take(5)->get();

        return view('dashboard', compact(
            'total',
            'pending',
            'inProgress',
            'completed',
            'pendingPercentage',
            'inProgressPercentage',
            'completedPercentage',
            'lastWeek',
            'recentAudits'
        ));
    }
}