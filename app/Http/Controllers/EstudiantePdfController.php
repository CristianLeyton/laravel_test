<?php

namespace App\Http\Controllers;

use App\Models\Estudiantes;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EstudiantePdfController extends Controller
{
    public function generarPdf($id)
    {
        $estudiante = Estudiantes::with([
            'aniodelacarrera',
            'estado',
            'lugarNacimiento',
            'domicilios.tipoDeDomicilio',
            'domicilios.localidad',
            'resoluciones',
            'arrestos.faltas.nivelesDeFaltas'
        ])->findOrFail($id);

        // Cargar las faltas para cada arresto
        $estudiante->arrestos->load('faltas.nivelesDeFaltas');

        $pdf = Pdf::loadView('pdf.estudiante-perfil', [
            'estudiante' => $estudiante
        ]);

        $filename = 'perfil_cadete_' . $estudiante->dni_estudiante . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}
