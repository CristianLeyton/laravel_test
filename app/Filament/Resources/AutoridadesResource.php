<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AutoridadesResource\Pages;
use App\Models\Autoridades;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AutoridadesResource extends Resource
{
    protected static ?string $model = Autoridades::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $navigationGroup = 'Tablas de datos';
    protected static ?string $modelLabel = 'autoridad';
    protected static ?string $pluralModelLabel = 'autoridades';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_autoridad')
                    ->label('Nombre')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('cargo_autoridad')
                    ->label('Cargo')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_autoridad')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cargo_autoridad')
                    ->label('Cargo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAutoridades::route('/'),
            'create' => Pages\CreateAutoridades::route('/create'),
            'edit' => Pages\EditAutoridades::route('/{record}/edit'),
        ];
    }
}
