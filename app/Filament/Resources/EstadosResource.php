<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstadosResource\Pages;
use App\Filament\Resources\EstadosResource\RelationManagers;
use App\Models\Estados;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class EstadosResource extends Resource
{
    protected static ?string $model = Estados::class;

    protected static ?string $modelLabel = 'estado';
    protected static ?string $pluralModelLabel = 'estados';
    protected static ?string $navigationGroup = 'Tablas de datos';
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_estado')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true)
                    ->validationMessages(
                        [
                            'unique' => 'El nombre debe ser único',
                            'max' => 'El nombre debe tener menos de 100 caracteres',
                            'required' => 'El nombre es requerido',
                        ]
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_estado')
                    ->searchable(),
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
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->before(function ($record, $action) {
                    if ($record->estudiantes()->count() > 0) {
                        Notification::make()
                            ->title('¡No se puede borrar!')
                            ->danger()
                            ->body('El registro "' . $record->nombre_estado . '" se está usando en ' . $record->estudiantes()->count() . ' estudiante(s).')
                            ->send();
                        $action->cancel();
                        return;
                    }
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->before(function ($records, $action) {
                        foreach ($records as $record) {
                            if ($record->estudiantes()->count() > 0) {
                                Notification::make()
                                    ->title('¡No se puede borrar!')
                                    ->danger()
                                    ->body('El registro "' . $record->nombre_estado . '" se está usando en ' . $record->estudiantes()->count() . ' estudiante(s).')
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
            'index' => Pages\ManageEstados::route('/'),
        ];
    }
}
