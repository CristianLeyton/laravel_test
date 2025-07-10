<?php

require_once 'vendor/autoload.php';

use App\Models\Estudiantes;
use Illuminate\Support\Facades\DB;

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Buscar un estudiante existente
    $estudiante = Estudiantes::first();

    if (!$estudiante) {
        echo "❌ No hay estudiantes en la base de datos\n";
        exit;
    }

    echo "✅ Estudiante encontrado:\n";
    echo "ID: " . $estudiante->id . "\n";
    echo "Nombre: " . $estudiante->nombre_estudiante . " " . $estudiante->apellido_estudiante . "\n";

    // Probar la consulta directa para obtener resoluciones
    $resolucionesIds = DB::table('estudiante_resolucion')
        ->where('estudiantes_id', $estudiante->id)
        ->pluck('resoluciones_id')
        ->toArray();

    echo "\n✅ IDs de resoluciones obtenidos: " . implode(', ', $resolucionesIds) . "\n";

    // Probar la relación Eloquent
    $resoluciones = $estudiante->resoluciones;
    echo "✅ Resoluciones via Eloquent:\n";
    foreach ($resoluciones as $resolucion) {
        echo "- " . $resolucion->numero_de_resolucion . "\n";
    }

    echo "\n✅ Total de resoluciones: " . $resoluciones->count() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
}
