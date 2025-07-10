<?php

namespace App\Filament\Resources\EstudiantesResource\Pages;

use App\Filament\Resources\EstudiantesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Exception;

class EditEstudiante extends EditRecord
{
    protected static string $resource = EstudiantesResource::class;

    protected array $domiciliosData = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Cargar los domicilios existentes en el formulario
        $domicilios = $this->record->domicilios()->get()->map(function ($domicilio) {
            return [
                'tipos_de_domicilios_id' => $domicilio->tipos_de_domicilios_id,
                'direccion_estudiante' => $domicilio->direccion_estudiante,
                'descripcion_domicilio' => $domicilio->descripcion_domicilio,
                'localidades_id' => $domicilio->localidades_id,
            ];
        })->toArray();

        $data['domicilios_data'] = $domicilios;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extraer los datos de domicilios del formulario
        $domicilios = $data['domicilios_data'] ?? [];
        $this->domiciliosData = $domicilios;
        unset($data['domicilios_data']);

        return $data;
    }

    protected function afterSave(): void
    {
        // Eliminar domicilios existentes y recrear
        $this->record->domicilios()->delete();

        // Crear los nuevos domicilios
        if (isset($this->domiciliosData) && is_array($this->domiciliosData)) {
            foreach ($this->domiciliosData as $domicilio) {
                $this->record->domicilios()->create($domicilio);
            }
        }
    }
}
