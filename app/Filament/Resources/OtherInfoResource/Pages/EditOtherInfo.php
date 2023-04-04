<?php

namespace App\Filament\Resources\OtherInfoResource\Pages;

use App\Filament\Resources\OtherInfoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOtherInfo extends EditRecord
{
    protected static string $resource = OtherInfoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
