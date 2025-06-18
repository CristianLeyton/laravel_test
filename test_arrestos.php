<?php

require_once 'vendor/autoload.php';

use App\Models\Arrestos;
use App\Models\Estudiantes;

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

    echo "✅ Estudiante encontrado: " . $estudiante->nombre_estudiante . " " . $estudiante->apellido_estudiante . "\n";

    // Crear un arresto para el estudiante
    $arresto = Arrestos::create([
        'estudiante_id' => $estudiante->id,
        'fecha_de_arresto' => now(),
        'dias_de_arresto' => 3,
    ]);

    echo "✅ Arresto creado exitosamente:\n";
    echo "ID: " . $arresto->id . "\n";
    echo "Estudiante: " . $arresto->estudiante->nombre_estudiante . " " . $arresto->estudiante->apellido_estudiante . "\n";
    echo "Fecha: " . $arresto->fecha_de_arresto->format('Y-m-d') . "\n";
    echo "Días: " . $arresto->dias_de_arresto . "\n";

    // Verificar las relaciones
    echo "\n✅ Relaciones verificadas:\n";
    echo "Estudiante tiene " . $estudiante->arrestos->count() . " arrestos\n";
    echo "Arresto pertenece a: " . $arresto->estudiante->nombre_estudiante . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
}
