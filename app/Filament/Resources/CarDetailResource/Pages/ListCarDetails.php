<?php

namespace App\Filament\Resources\CarDetailResource\Pages;

use App\Filament\Resources\CarDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCarDetails extends ListRecords
{
    protected static string $resource = CarDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
