<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtsResource\Pages;
use App\Models\Arts;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArtsResource extends Resource
{
    protected static ?string $model = Arts::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'ART';
    protected static ?string $navigationGroup = 'Cadetes';
    protected static ?string $modelLabel = 'ART';
    protected static ?string $pluralModelLabel = "ART";
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('estudiante_id')
                    ->label('Cadete')
                    ->relationship('estudiante', 'nombre_estudiante', function ($query) {
                        return $query->select('id', 'nombre_estudiante', 'apellido_estudiante')
                            ->orderBy('nombre_estudiante');
                    })
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->nombre_estudiante . ' ' . $record->apellido_estudiante)
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\DatePicker::make('fecha')
                    ->label('Fecha')
                    ->default(now()->format('Y-m-d'))
                    ->required(),

                Forms\Components\TextInput::make('dias')
                    ->label('Días')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(365),

                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\Select::make('autoridad_id')
                    ->label('Autoridad que respalda')
                    ->relationship('autoridad', 'nombre_autoridad')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nombre_autoridad')
                            ->label('Nombre de la autoridad')
                            ->required(),
                        Forms\Components\TextInput::make('cargo_autoridad')
                            ->label('Cargo')
                            ->maxLength(100),
                    ])
                    ->createOptionModalHeading('Crear autoridad')
                    ->helperText('Seleccione o cree la autoridad'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('estudiante.nombre_estudiante')
                    ->label('Cadete')
                    ->formatStateUsing(fn($record) => $record->estudiante->nombre_estudiante . ' ' . $record->estudiante->apellido_estudiante)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date()
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                Tables\Columns\TextColumn::make('dias')
                    ->label('Días')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(80)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('autoridad')
                    ->label('Autoridad')
                    ->formatStateUsing(fn($record) => $record->autoridad ? ($record->autoridad->nombre_autoridad . ($record->autoridad->cargo_autoridad ? ' (' . $record->autoridad->cargo_autoridad . ')' : '')) : '—')
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArts::route('/'),
            'create' => Pages\CreateArts::route('/create'),
            'edit' => Pages\EditArts::route('/{record}/edit'),
        ];
    }
}
