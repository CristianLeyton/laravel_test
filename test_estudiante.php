<?php

require_once 'vendor/autoload.php';

use App\Models\Estudiantes;
use App\Models\Resoluciones;

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Crear un estudiante de prueba
    $estudiante = Estudiantes::create([
        'nombre_estudiante' => 'Juan',
        'apellido_estudiante' => 'Pérez',
        'dni_estudiante' => '12345678',
        'cuil_estudiante' => '20-12345678-9',
        'fecha_nacimiento' => '1995-01-15',
        'num_legajo' => 'LEG001',
        'aniodelacarrera_id' => 1,
        'estado_id' => 3, // Activo
    ]);

    // Asociar múltiples resoluciones al estudiante
    $estudiante->resoluciones()->attach([1, 2]);

    echo "✅ Estudiante creado exitosamente:\n";
    echo "ID: " . $estudiante->id . "\n";
    echo "Nombre: " . $estudiante->nombre_estudiante . " " . $estudiante->apellido_estudiante . "\n";
    echo "DNI: " . $estudiante->dni_estudiante . "\n";
    echo "Legajo: " . $estudiante->num_legajo . "\n";

    // Verificar las resoluciones asociadas
    echo "\n✅ Resoluciones asociadas:\n";
    foreach ($estudiante->resoluciones as $resolucion) {
        echo "- " . $resolucion->numero_de_resolucion . "\n";
    }

    // Verificar relaciones
    echo "\n✅ Relaciones verificadas:\n";
    echo "Año de carrera: " . $estudiante->aniodelacarrera->nombre . "\n";
    echo "Estado: " . $estudiante->estado->nombre_estado . "\n";
    echo "Número de resoluciones: " . $estudiante->resoluciones->count() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
}
