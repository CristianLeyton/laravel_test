<?php

namespace App\Filament\Resources\EstudiantesResource\Pages;

use App\Filament\Resources\EstudiantesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEstudiante extends CreateRecord
{
    protected static string $resource = EstudiantesResource::class;

    protected array $domiciliosData = [];
    protected array $resolucionesData = [];

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extraer los datos de domicilios del formulario
        $domicilios = $data['domicilios_data'] ?? [];
        $this->domiciliosData = $domicilios;
        unset($data['domicilios_data']);

        // Extraer los datos de resoluciones del formulario
        $resoluciones = $data['resoluciones'] ?? [];
        $this->resolucionesData = $resoluciones;
        unset($data['resoluciones']);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Crear los domicilios después de crear el estudiante
        if (isset($this->domiciliosData) && is_array($this->domiciliosData)) {
            foreach ($this->domiciliosData as $domicilio) {
                $this->record->domicilios()->create($domicilio);
            }
        }

        // Asociar las resoluciones al estudiante
        if (isset($this->resolucionesData) && is_array($this->resolucionesData)) {
            $this->record->resoluciones()->attach($this->resolucionesData);
        }
    }
}
