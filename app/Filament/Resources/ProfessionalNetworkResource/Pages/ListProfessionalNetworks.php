<?php

namespace App\Filament\Resources\ProfessionalNetworkResource\Pages;

use App\Filament\Resources\ProfessionalNetworkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfessionalNetworks extends ListRecords
{
    protected static string $resource = ProfessionalNetworkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
