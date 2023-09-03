<?php

namespace App\Filament\Resources\TestResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\TestResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;

class ListTests extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = TestResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
