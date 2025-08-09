<?php

namespace App\Filament\Resources\ArtsResource\Pages;

use App\Filament\Resources\ArtsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArts extends CreateRecord
{
    protected static string $resource = ArtsResource::class;

    protected static bool $shouldCreateInModal = true;
}
