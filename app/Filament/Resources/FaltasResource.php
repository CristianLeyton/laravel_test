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
                ->required(),
            Forms\Components\Select::make('niveles_de_faltas_id')
                ->relationship('nivelesDeFaltas', 'nombre_de_nivel')
                ->label('Nivel de falta')
                ->required()
                ->preload(),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_de_falta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nivelesDeFaltas.nombre_de_nivel')
                ->label('Nivel de falta')
                ->searchable()
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
            ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFaltas::route('/'),
        ];
    }
}
