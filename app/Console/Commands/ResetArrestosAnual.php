<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Estudiantes;
use App\Models\Arrestos;
use Carbon\Carbon;

class ResetArrestosAnual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arrestos:reset-anual {--anio= : Año específico para resetear (por defecto año actual)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resetea los contadores de arrestos para un año específico y muestra estadísticas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $anio = $this->option('anio') ?? now()->year;

        $this->info("=== RESETEO DE ARRESTOS ANUALES ===");
        $this->info("Año objetivo: {$anio}");
        $this->newLine();

        // Mostrar estadísticas antes del reseteo
        $this->mostrarEstadisticas($anio);

        $this->newLine();
        $this->info("=== RESUMEN ===");
        $this->info("El sistema de arrestos se resetea automáticamente cada año.");
        $this->info("Los contadores se calculan solo para el año actual ({$anio}).");
        $this->info("El historial completo se mantiene para consultas.");
        $this->info("Límite anual: " . Arrestos::LIMITE_DIAS_ARRESTO . " días");

        return Command::SUCCESS;
    }

    private function mostrarEstadisticas($anio)
    {
        $this->info("Estadísticas del año {$anio}:");

        // Total de arrestos del año
        $totalArrestosAnio = Arrestos::getTotalDiasPorAnio($anio);
        $this->line("• Total de días de arresto: {$totalArrestosAnio}");

        // Estudiantes con arrestos en el año
        $estudiantesConArrestos = Arrestos::whereRaw('strftime("%Y", fecha_de_arresto) = ?', [$anio])
            ->distinct('estudiante_id')
            ->count('estudiante_id');
        $this->line("• Estudiantes con arrestos: {$estudiantesConArrestos}");

        // Estudiantes superando el límite
        $estudiantesSuperandoLimite = Arrestos::select('estudiante_id')
            ->whereRaw('strftime("%Y", fecha_de_arresto) = ?', [$anio])
            ->groupBy('estudiante_id')
            ->havingRaw('SUM(dias_de_arresto) >= ?', [Arrestos::LIMITE_DIAS_ARRESTO])
            ->count();
        $this->line("• Estudiantes superando límite: {$estudiantesSuperandoLimite}");

        // Total histórico
        $totalHistorico = Arrestos::sum('dias_de_arresto');
        $this->line("• Total histórico de arrestos: {$totalHistorico}");

        $this->newLine();
        $this->info("Estadísticas del año actual (" . now()->year . "):");

        $anioActual = now()->year;
        $totalArrestosActual = Arrestos::getTotalDiasPorAnio($anioActual);
        $this->line("• Total de días de arresto: {$totalArrestosActual}");

        $estudiantesConArrestosActual = Arrestos::whereRaw('strftime("%Y", fecha_de_arresto) = ?', [$anioActual])
            ->distinct('estudiante_id')
            ->count('estudiante_id');
        $this->line("• Estudiantes con arrestos: {$estudiantesConArrestosActual}");

        $estudiantesSuperandoLimiteActual = Arrestos::select('estudiante_id')
            ->whereRaw('strftime("%Y", fecha_de_arresto) = ?', [$anioActual])
            ->groupBy('estudiante_id')
            ->havingRaw('SUM(dias_de_arresto) >= ?', [Arrestos::LIMITE_DIAS_ARRESTO])
            ->count();
        $this->line("• Estudiantes superando límite: {$estudiantesSuperandoLimiteActual}");
    }
}
