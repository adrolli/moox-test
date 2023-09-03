<?php

namespace App\Filament\Resources\TestResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\TestResource;

class ViewTest extends ViewRecord
{
    protected static string $resource = TestResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make(), DeleteAction::make()];
    }
}
