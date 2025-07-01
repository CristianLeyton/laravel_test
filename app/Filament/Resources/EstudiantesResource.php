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
                    ->maxLength(100)
                    ->validationMessages(
                        [
                            'required' => 'El nombre es requerido',
                            'max' => 'El nombre debe tener menos de 100 caracteres',
                        ]
                    ),

                Forms\Components\TextInput::make('apellido_estudiante')
                    ->label('Apellido')
                    ->required()
                    ->maxLength(100)
                    ->validationMessages(
                        [
                            'required' => 'El apellido es requerido',
                            'max' => 'El apellido debe tener menos de 100 caracteres',
                        ]
                    ),

                Forms\Components\TextInput::make('dni_estudiante')
                    ->label('DNI')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
                    ->numeric()
                    ->validationMessages(
                        [
                            'required' => 'El DNI es requerido',
                            'max' => 'El DNI debe tener menos de 20 caracteres',
                            'unique' => 'El DNI ya existe en la base de datos',
                            'numeric' => 'El DNI debe ser numérico',
                        ]
                    ),

                Forms\Components\TextInput::make('cuil_estudiante')
                    ->label('CUIL')
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
                    ->numeric()
                    ->validationMessages(
                        [
                            'max' => 'El CUIL debe tener menos de 20 caracteres',
                            'unique' => 'El CUIL ya existe en la base de datos',
                            'numeric' => 'El CUIL debe ser numérico',
                        ]
                    ),

                Forms\Components\DatePicker::make('fecha_nacimiento')
                    ->label('Fecha de Nacimiento'),

                Forms\Components\TextInput::make('num_legajo')
                    ->label('Número de Legajo')
                    ->maxLength(50)
                    ->validationMessages(
                        [
                            'max' => 'El número de legajo debe tener menos de 50 caracteres',
                        ]
                    ),

                Forms\Components\Select::make('aniodelacarrera_id')
                    ->label('Año de la Carrera')
                    ->relationship('aniodelacarrera', 'nombre')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->default(1)
                    ->validationMessages(
                        [
                            'required' => 'El año de la carrera es requerido',
                        ]
                    ),

                Forms\Components\Select::make('estado_id')
                    ->label('Estado')
                    ->relationship('estado', 'nombre_estado')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->default(1)
                    ->validationMessages(
                        [
                            'required' => 'El estado es requerido',
                        ]
                    ),

                Forms\Components\FileUpload::make('foto_estudiante')
                    ->label('Foto')
                    ->image()
                    ->directory('estudiantes')
                    ->nullable(),

                Forms\Components\Textarea::make('observaciones')
                    ->label('Observaciones')
                    ->nullable()
                    ->maxLength(500)
                    ->validationMessages(
                        [
                            'max' => 'La observacion debe tener menos de 500 caracteres',
                        ]
                    ),

                Forms\Components\Repeater::make('domicilios_data')
                    ->label('Domicilios')
                    ->schema([
                        Forms\Components\Select::make('tipos_de_domicilios_id')
                            ->label('Tipo de Domicilio')
                            ->default(1)
                            ->options(function () {
                                return \App\Models\TiposDeDomicilios::pluck('nombre_tipo_domicilio', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->validationMessages(
                                [
                                    'required' => 'El tipo de domicilio es requerido',
                                ]
                            ),

                        Forms\Components\TextInput::make('direccion_estudiante')
                            ->label('Dirección')
                            ->required()
                            ->maxLength(255)
                            ->validationMessages(
                                [
                                    'required' => 'La dirección es requerida',
                                    'max' => 'La dirección debe tener menos de 255 caracteres',
                                ]
                            ),

                        Forms\Components\Textarea::make('descripcion_domicilio')
                            ->label('Descripción')
                            ->nullable()
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->validationMessages(
                                [
                                    'max' => 'La descripción debe tener menos de 500 caracteres',
                                ]
                            ),

                        Forms\Components\Select::make('localidades_id')
                            ->label('Localidad')
                            ->options(function () {
                                return \App\Models\Localidades::pluck('nombre_localidad', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->validationMessages(
                                [
                                    'required' => 'La localidad es requerida',
                                ]
                            ),
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
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->estado && $record->estado->nombre_estado === 'Dado de baja') {
                            return '<span style="text-decoration: line-through;">' . e($state) . '</span>';
                        }
                        return e($state);
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('apellido_estudiante')
                    ->label('Apellido')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->estado && $record->estado->nombre_estado === 'Dado de baja') {
                            return '<span style="text-decoration: line-through;">' . e($state) . '</span>';
                        }
                        return e($state);
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('dni_estudiante')
                    ->label('DNI')
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->estado && $record->estado->nombre_estado === 'Dado de baja') {
                            return '<span style="text-decoration: line-through;">' . e($state) . '</span>';
                        }
                        return e($state);
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('num_legajo')
                    ->label('Legajo')
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->estado && $record->estado->nombre_estado === 'Dado de baja') {
                            return '<span style="text-decoration: line-through;">' . e($state) . '</span>';
                        }
                        return e($state);
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('aniodelacarrera.nombre')
                    ->label('Año de Carrera')
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->estado && $record->estado->nombre_estado === 'Dado de baja') {
                            return '<span style="text-decoration: line-through;">' . e($state) . '</span>';
                        }
                        return e($state);
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('estado.nombre_estado')
                    ->label('Estado')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('aniodelacarrera_id')
                    ->label('Año de la Carrera')
                    ->options(function () {
                        return \App\Models\Aniodelacarrera::pluck('nombre', 'id');
                    }),

                Tables\Filters\SelectFilter::make('estado_id')
                    ->label('Estado')
                    ->options(function () {
                        return \App\Models\Estados::pluck('nombre_estado', 'id');
                    }),
            ])
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
