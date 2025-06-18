<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DomiciliosResource\Pages;
use App\Filament\Resources\DomiciliosResource\RelationManagers;
use App\Models\Domicilios;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DomiciliosResource extends Resource
{
    protected static ?string $model = Domicilios::class;

    protected static ?string $modelLabel = 'domicilio';
    protected static ?string $pluralModelLabel = 'domicilios';
    protected static ?string $navigationGroup = 'Tablas de datos';
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    //protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('estudiantes_id')
                    ->relationship('estudiante', 'nombre_estudiante')
                    ->label('Estudiante')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('tipos_de_domicilios_id')
                    ->relationship('tiposDeDomicilios', 'nombre_tipo_domicilio')
                    ->label('Tipo de domicilio')
                    ->required(),
                Forms\Components\TextInput::make('descripcion_domicilio')
                    ->label('Descripción')
                    ->default('Casa'),
                Forms\Components\TextInput::make('direccion_estudiante')
                    ->label('Dirección')
                    ->required(),
                Forms\Components\Select::make('localidades_id')
                    ->label('Localidad')
                    ->relationship('localidades', 'nombre_localidad')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('estudiante.nombre_estudiante')
                    ->label('Estudiante')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estudiante.apellido_estudiante')
                    ->label('Apellido')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tiposDeDomicilios.nombre_tipo_domicilio')
                    ->label('Tipo de domicilio')
                    ->sortable(),
                Tables\Columns\TextColumn::make('descripcion_domicilio')
                    ->label('Descripción')
                    ->searchable(),
                Tables\Columns\TextColumn::make('direccion_estudiante')
                    ->label('Dirección')
                    ->searchable(),
                Tables\Columns\TextColumn::make('localidades.nombre_localidad')
                    ->label('Localidad')
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
            'index' => Pages\ManageDomicilios::route('/'),
        ];
    }
}
