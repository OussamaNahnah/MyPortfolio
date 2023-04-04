<?php

namespace App\Filament\Resources\OtherInfoResource\Pages;

use App\Filament\Resources\OtherInfoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOtherInfos extends ListRecords
{
    protected static string $resource = OtherInfoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
