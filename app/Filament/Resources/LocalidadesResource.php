<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocalidadesResource\Pages;
use App\Filament\Resources\LocalidadesResource\RelationManagers;
use App\Models\Localidades;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class LocalidadesResource extends Resource
{
    protected static ?string $model = Localidades::class;

        protected static ?string $modelLabel = 'localidad';
        protected static ?string $pluralModelLabel = 'localidades';
        protected static ?string $navigationGroup = 'Tablas de datos';
        protected static ?string $navigationIcon = 'heroicon-o-map';
        //protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_localidad')
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
                Tables\Columns\TextColumn::make('nombre_localidad')
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
                        if ($record->domicilios()->count() > 0) {
                            Notification::make()
                            ->title('¡No se puede borrar!')
                            ->danger()
                            ->body('El registro "' . $record->nombre_localidad . '" se está usando en ' . $record->domicilios()->count() . ' domicilio(s).')
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
                                if ($record->domicilios()->count() > 0) {
                                    Notification::make()
                                        ->title('¡No se puede borrar!')
                                        ->danger()
                                        ->body('El registro "' . $record->nombre_localidad . '" se está usando en ' . $record->domicilios()->count() . ' domicilio(s).')
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
            'index' => Pages\ManageLocalidades::route('/'),
        ];
    }
}
