<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaltasResource\Pages;
use App\Filament\Resources\FaltasResource\RelationManagers;
use App\Models\Faltas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;
use Filament\Notifications\Notification;


class FaltasResource extends Resource
{
    protected static ?string $model = Faltas::class;

    protected static ?string $modelLabel = 'falta';
    protected static ?string $pluralModelLabel = 'faltas';
    protected static ?string $navigationGroup = 'Tablas de datos';
    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';
    //protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_de_falta')
                    ->required()
                    ->maxLength(500)
                    ->unique(ignoreRecord: true)
                    ->validationMessages(
                        [
                            'unique' => 'El nombre debe ser único',
                            'max' => 'El nombre debe tener menos de 500 caracteres',
                            'required' => 'El nombre es requerido',
                        ]
                    ),
                Forms\Components\Select::make('niveles_de_faltas_id')
                    ->relationship('nivelesDeFaltas', 'nombre_de_nivel')
                    ->label('Nivel de falta')
                    ->required()
                    ->preload()
                    ->validationMessages(
                        [
                            'required' => 'El nivel de falta es requerido',
                        ]
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_de_falta')
                    ->searchable()
                    ->label('Falta') // limita a 250 caracteres
                    ->wrap() // permite que el texto haga salto de línea (no trunca)
                    ->sortable()
                    ->extraAttributes([
                        'class' => 'whitespace-normal', // tailwind: permite saltos de línea
                    ]),
                Tables\Columns\TextColumn::make('nivelesDeFaltas.nombre_de_nivel')
                    ->label('Nivel de falta')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('niveles_de_faltas_id')
                    ->label('Nivel de falta')
                    ->options(function () {
                        return \App\Models\NivelesDeFaltas::pluck('nombre_de_nivel', 'id');
                    })
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->before(function ($record, $action) {
                    if ($record->arrestos()->count() > 0) {
                        Notification::make()
                            ->title('¡No se puede borrar!')
                            ->danger()
                            ->body('El registro "' . $record->nombre_de_falta . '" se está usando en ' . $record->arrestos()->count() . ' arresto(s).')
                            ->send();
                        $action->cancel();
                        return;
                    }
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records, $action) {
                            foreach ($records as $record) {
                                if ($record->arrestos()->count() > 0) {
                                    Notification::make()
                                        ->title('¡No se puede borrar!')
                                        ->danger()
                                        ->body('El registro "' . $record->nombre_de_falta . '" se está usando en ' . $record->arrestos()->count() . ' arresto(s).')
                                        ->send();
                                    $action->cancel();
                                    return;
                                }
                            }
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFaltas::route('/'),
        ];
    }
}
