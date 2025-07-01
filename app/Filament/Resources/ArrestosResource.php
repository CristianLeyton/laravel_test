<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArrestosResource\Pages;
use App\Filament\Resources\ArrestosResource\RelationManagers;
use App\Models\Arrestos;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArrestosResource extends Resource
{
    protected static ?string $model = Arrestos::class;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';
    protected static ?string $navigationLabel = 'Arrestos';
    protected static ?string $navigationGroup = 'Cadetes';
    protected static ?string $modelLabel = 'Arresto';
    protected static ?string $pluralModelLabel = 'Arrestos';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('estudiante_id')
                    ->label('Estudiante')
                    ->relationship('estudiante', 'nombre_estudiante', function ($query) {
                        return $query->select('id', 'nombre_estudiante', 'apellido_estudiante')
                            ->orderBy('nombre_estudiante');
                    })
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->nombre_estudiante . ' ' . $record->apellido_estudiante)
                    ->required()
                    ->searchable()
                    ->preload()
                    ->validationMessages(
                        [
                            'required' => 'El estudiante es requerido',
                        ]
                    ),

                Forms\Components\DatePicker::make('fecha_de_arresto')
                    ->label('Fecha de Arresto')
                    ->default(now()->format('Y-m-d'))
                    ->required()
                    ->validationMessages(
                        [
                            'required' => 'La fecha es requerida',
                        ]
                    ),

                Forms\Components\TextInput::make('dias_de_arresto')
                    ->label('Días de Arresto')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(31)
                    ->validationMessages(
                        [
                            'required' => 'Ingrese días de arresto',
                            'numeric' => 'Ingrese un numero válido',
                            'min' => 'Ingrese un número mayor o igual a 1',
                            'max' => 'Ingrese un número menor o igual a 31',
                        ]
                    ),

                Forms\Components\Select::make('faltas')
                    ->label('Faltas')
                    ->relationship('faltas', 'nombre_de_falta')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->nombre_de_falta . ' (' . $record->nivelesDeFaltas->nombre_de_nivel . ')')
                    ->createOptionModalHeading('Crear falta')
                    ->createOptionForm([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('nombre_de_falta')
                                ->required()
                                ->validationMessages(
                                    [
                                        'required' => 'El nombre es requerido',
                                    ]
                                ),
                            Forms\Components\Select::make('niveles_de_faltas_id')
                                ->relationship('nivelesDeFaltas', 'nombre_de_nivel')
                                ->required()
                                ->preload()
                                ->validationMessages(
                                    [
                                        'required' => 'El nivel de falta es requerido',
                                    ]
                                ),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('estudiante.nombre_estudiante')
                    ->label('Estudiante')
                    ->formatStateUsing(fn($record) => $record->estudiante->nombre_estudiante . ' ' . $record->estudiante->apellido_estudiante)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha_de_arresto')
                    ->label('Fecha de Arresto')
                    ->badge()
                    ->color('gray')
                    ->date()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('dias_de_arresto')
                    ->label('Días')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('faltas.nivelesDeFaltas.nombre_de_nivel')
                    ->label('Faltas')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Leve' => 'info',
                        'Grave' => 'warning',
                        'Muy Grave' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->listWithLineBreaks(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Detalles del Arresto')
                    ->modalContent(function ($record) {
                        return view('filament.resources.arrestos.modal-content', ['arresto' => $record]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Cerrar'),
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
            'index' => Pages\ManageArrestos::route('/'),
        ];
    }
}
