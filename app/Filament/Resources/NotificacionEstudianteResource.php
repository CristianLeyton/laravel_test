<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificacionEstudianteResource\Pages;
use App\Models\NotificacionEstudiante;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EstudiantesResource;

class NotificacionEstudianteResource extends Resource
{
    protected static ?string $model = NotificacionEstudiante::class;
    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';
    protected static ?string $navigationLabel = 'Notificaciones';
    protected static ?string $navigationGroup = 'Cadetes';
    protected static ?string $modelLabel = 'Notificación';
    protected static ?string $pluralModelLabel = 'Notificaciones';
    protected static ?int $navigationSort = 5;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([]); // No crear ni editar
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mensaje')
                    ->label('Mensaje')
                    ->wrap(),
                Tables\Columns\TextColumn::make('estudiante.nombre_estudiante')
                    ->label('Estudiante')
                    ->formatStateUsing(fn($state, $record) => $record->estudiante ? $record->estudiante->nombre_estudiante . ' ' . $record->estudiante->apellido_estudiante : '-')
                    ->searchable(['estudiante.nombre_estudiante', 'estudiante.apellido_estudiante'])
                    ->url(fn($record) => EstudiantesResource::getUrl('view', ['record' => $record->estudiante_id]), true)
                    ->openUrlInNewTab(),
                Tables\Columns\IconColumn::make('leida')
                    ->label('Leída')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('ver')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn($record) => EstudiantesResource::getUrl('view', ['record' => $record->estudiante_id]), true),
                Tables\Actions\Action::make('marcar_leida')
                    ->label('Leída')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn($record) => !$record->leida)
                    ->action(function ($record) {
                        $record->leida = true;
                        $record->save();
                    }),
            ])
            ->bulkActions([]);
    }

    public static function getNavigationBadge(): ?string
    {
        $count = NotificacionEstudiante::where('leida', false)->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotificacionEstudiantes::route('/'),
        ];
    }
}
