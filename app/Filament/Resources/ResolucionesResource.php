<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResolucionesResource\Pages;
use App\Filament\Resources\ResolucionesResource\RelationManagers;
use App\Models\Resoluciones;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResolucionesResource extends Resource
{
    protected static ?string $model = Resoluciones::class;

    protected static ?string $modelLabel = 'resolución';
    protected static ?string $pluralModelLabel = 'resoluciones';
    protected static ?string $navigationGroup = 'Cadetes';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Resoluciones';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('estudiante_id')
                    ->label('Estudiante')
                    ->searchable()
                    ->preload()
                    ->options(function () {
                        return \App\Models\Estudiantes::all()->mapWithKeys(function ($estudiante) {
                            return [
                                $estudiante->id => $estudiante->nombre_estudiante . ' ' . $estudiante->apellido_estudiante
                            ];
                        });
                    })
                    ->getSearchResultsUsing(function (string $search) {
                        return \App\Models\Estudiantes::query()
                            ->where('nombre_estudiante', 'like', "%{$search}%")
                            ->orWhere('apellido_estudiante', 'like', "%{$search}%")
                            ->orWhere('dni_estudiante', 'like', "%{$search}%")
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(function ($estudiante) {
                                return [
                                    $estudiante->id => $estudiante->nombre_estudiante . ' ' . $estudiante->apellido_estudiante
                                ];
                            });
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $estudiante = \App\Models\Estudiantes::find($value);
                        return $estudiante ? $estudiante->nombre_estudiante . ' ' . $estudiante->apellido_estudiante : '';
                    })
                    ->required()
                    ->validationMessages([
                        'required' => 'Seleccione un estudiante'
                    ]),
                Forms\Components\TextInput::make('numero_de_resolucion')
                    ->label('Número de resolución')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->validationMessages([
                        'unique' => 'Ya existe una resolucion con este número',
                        'required' => 'Indique número de resolución'
                    ]),
                Forms\Components\FileUpload::make('foto')
                    ->label('Foto de la resolución')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                    ->directory('resoluciones')
                    ->validationMessages([
                        'mimetypes' => 'El archivo debe ser una imagen válida (JPG, PNG, GIF, WebP)'
                    ]),
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
                Tables\Columns\TextColumn::make('numero_de_resolucion')
                    ->label('Número de resolución')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->openUrlInNewTab()
                    ->sortable()
                    ->url(fn($record) => $record->foto ? asset('storage/' . $record->foto) : null),
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
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Detalles de la Resolución')
                    ->modalContent(function ($record) {
                        return view('filament.resources.resoluciones.modal-content', ['resolucion' => $record]);
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
            'index' => Pages\ManageResoluciones::route('/'),
        ];
    }
}
