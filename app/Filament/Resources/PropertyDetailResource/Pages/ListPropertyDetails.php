<?php

namespace App\Filament\Resources\PropertyDetailResource\Pages;

use App\Filament\Resources\PropertyDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPropertyDetails extends ListRecords
{
    protected static string $resource = PropertyDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
