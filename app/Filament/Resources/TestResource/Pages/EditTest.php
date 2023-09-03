<?php

namespace App\Filament\Resources\TestResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\TestResource;
use Filament\Resources\Pages\EditRecord;

class EditTest extends EditRecord
{
    protected static string $resource = TestResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
