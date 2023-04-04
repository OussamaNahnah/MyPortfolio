<?php

namespace App\Filament\Resources\PhoneNumberResource\Pages;

use App\Filament\Resources\PhoneNumberResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhoneNumber extends EditRecord
{
    protected static string $resource = PhoneNumberResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
