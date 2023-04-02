<?php

namespace App\Filament\Resources\ProfessionalNetworkResource\Pages;

use App\Filament\Resources\ProfessionalNetworkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfessionalNetwork extends EditRecord
{
    protected static string $resource = ProfessionalNetworkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
