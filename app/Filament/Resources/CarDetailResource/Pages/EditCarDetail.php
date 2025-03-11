<?php

namespace App\Filament\Resources\CarDetailResource\Pages;

use App\Filament\Resources\CarDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCarDetail extends EditRecord
{
    protected static string $resource = CarDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
