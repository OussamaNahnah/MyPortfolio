<?php

namespace App\Filament\Resources\JobResponsibilityResource\Pages;

use App\Filament\Resources\JobResponsibilityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobResponsibilities extends ListRecords
{
    protected static string $resource = JobResponsibilityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
