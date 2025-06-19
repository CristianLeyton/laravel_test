<?php

namespace App\Filament\Resources;

use App\Models\Estudiantes;
use Filament\Tables;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\EstudiantesResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Get;
use Filament\Forms\Set;

class EstudiantesResource extends Resource
{
    protected static ?string $model = Estudiantes::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Estudiantes';
    protected static ?string $navigationGroup = 'Cadetes';
    protected static ?string $modelLabel = 'Estudiante';
    protected static ?string $pluralModelLabel = 'Estudiantes';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_estudiante')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('apellido_estudiante')
                    ->label('Apellido')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('dni_estudiante')
                    ->label('DNI')
                    ->required()
                    ->maxLength(20),

                Forms\Components\TextInput::make('cuil_estudiante')
                    ->label('CUIL')
                    ->required()
                    ->maxLength(20),

                Forms\Components\DatePicker::make('fecha_nacimiento')
                    ->label('Fecha de Nacimiento')
                    ->required(),

                Forms\Components\TextInput::make('num_legajo')
                    ->label('Número de Legajo')
                    ->required()
                    ->maxLength(50),

                Forms\Components\Select::make('aniodelacarrera_id')
                    ->label('Año de la Carrera')
                    ->relationship('aniodelacarrera', 'nombre')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('estado_id')
                    ->label('Estado')
                    ->relationship('estado', 'nombre_estado')
                    ->required()
                    ->searchable()
                    ->preload(),

                    Forms\Components\FileUpload::make('foto_estudiante')
                    ->label('Foto')
                    ->image()
                    ->directory('estudiantes')
                    ->nullable(),

                Forms\Components\Repeater::make('domicilios_data')
                    ->label('Domicilios')
                    ->schema([
                        Forms\Components\Select::make('tipos_de_domicilios_id')
                            ->label('Tipo de Domicilio')
                            ->options(function () {
                                return \App\Models\TiposDeDomicilios::pluck('nombre_tipo_domicilio', 'id');
                            })
                            ->required()
                            ->searchable(),

                        Forms\Components\TextInput::make('direccion_estudiante')
                            ->label('Dirección')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('descripcion_domicilio')
                            ->label('Descripción')
                            ->nullable()
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('localidades_id')
                            ->label('Localidad')
                            ->options(function () {
                                return \App\Models\Localidades::pluck('nombre_localidad', 'id');
                            })
                            ->required()
                            ->searchable(),
                    ])
                    ->defaultItems(1)
                    ->columns(2)
                    ->addActionLabel('Agregar domicilio')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_estudiante')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('apellido_estudiante')
                    ->label('Apellido')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('dni_estudiante')
                    ->label('DNI')
                    ->searchable(),

                Tables\Columns\TextColumn::make('num_legajo')
                    ->label('Legajo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('aniodelacarrera.nombre')
                    ->label('Año de Carrera')
                    ->sortable(),

                Tables\Columns\TextColumn::make('estado.nombre_estado')
                    ->label('Estado')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListEstudiantes::route('/'),
            'create' => Pages\CreateEstudiante::route('/create'),
            'view' => Pages\ViewEstudiante::route('/{record}'),
            'edit' => Pages\EditEstudiante::route('/{record}/edit'),
        ];
    }
}
