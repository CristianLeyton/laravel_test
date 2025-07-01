<?php

namespace App\Filament\Widgets;

use App\Models\Estudiantes;
use App\Filament\Resources\EstudiantesResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Estados;

class EstudiantesArrestosWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Estudiantes::query()
                    ->withSum('arrestos', 'dias_de_arresto')
                    ->with('estado', 'aniodelacarrera')
            )
            ->columns([
                TextColumn::make('nombre_estudiante')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('apellido_estudiante')
                    ->label('Apellido')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('num_legajo')
                    ->label('Legajo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('aniodelacarrera.nombre')
                    ->label('Año de Carrera')
                    ->sortable(),
                TextColumn::make('estado.nombre_estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Activo' => 'success',
                        'Inactivo' => 'danger',
                        'Suspendido' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('arrestos_sum_dias_de_arresto')
                    ->label('Días de Arresto')
                    /*                     ->summarize([
                        Sum::make()
                            ->label('Total')
                    ])  */
                    ->sortable()
                    ->default(0)
                    ->extraAttributes([
                        'class' => 'w-full text-center',
                    ]),
            ])
            ->filters([
                SelectFilter::make('estado')
                    ->relationship('estado', 'nombre_estado')
                    ->label('Estado'),
            ])
            ->actions([
                Action::make('ver_detalles')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn($record) => EstudiantesResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('arrestos_sum_dias_de_arresto', 'desc')
            ->striped()
            ->paginated([10, 25, 50]);
    }

    protected function getTableHeading(): string
    {
        return 'Arrestos de estudiantes';
    }
}
