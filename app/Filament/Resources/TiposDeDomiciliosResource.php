<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TiposDeDomiciliosResource\Pages;
use App\Filament\Resources\TiposDeDomiciliosResource\RelationManagers;
use App\Models\TiposDeDomicilios;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class TiposDeDomiciliosResource extends Resource
{
    protected static ?string $model = TiposDeDomicilios::class;

    //protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'tipo de domicilio';
    protected static ?string $pluralModelLabel = 'tipos de domicilios';
    protected static ?string $navigationGroup = 'Tablas de datos';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_tipo_domicilio')
                    ->required()
                    ->validationMessages(
                        [
                            'unique' => 'El nombre debe ser único'
                        ]
                    )
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_tipo_domicilio')
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
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record, $action) {
                        if ($record->domicilios()->count() > 0) {
                            Notification::make()
                            ->title('¡No se puede borrar!')
                            ->danger()
                            ->body('El registro "' . $record->nombre_tipo_domicilio . '" se está usando en ' . $record->domicilios()->count() . ' domicilio(s).')
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
                                        ->body('El registro "' . $record->nombre_tipo_domicilio . '" se está usando en ' . $record->domicilios()->count() . ' domicilio(s).')
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
            'index' => Pages\ManageTiposDeDomicilios::route('/'),
        ];
    }
}
