<?php

namespace App\Filament\Resources\PhoneNumberResource\Pages;

use App\Filament\Resources\PhoneNumberResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhoneNumbers extends ListRecords
{
    protected static string $resource = PhoneNumberResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
