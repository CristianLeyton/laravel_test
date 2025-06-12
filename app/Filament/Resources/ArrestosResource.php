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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('fecha_de_arresto')
                    ->default(now()->format('Y-m-d'))
                    ->required(),
                Forms\Components\TextInput::make('dias_de_arresto')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('colors')
                    ->label('Faltas: ')
                    ->relationship('faltas', 'nombre_de_falta')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->createOptionModalHeading('Crear falta')
                    ->createOptionForm([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('nombre_de_falta')
                                ->required(),
                            Forms\Components\Select::make('niveles_de_faltas_id')
                                ->relationship('nivelesDeFaltas', 'nombre_de_nivel')
                                ->required()
                                ->preload(),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fecha_de_arresto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dias_de_arresto')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('faltas.nombre_de_falta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('faltas.nivelesDeFaltas.nombre_de_nivel')
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
