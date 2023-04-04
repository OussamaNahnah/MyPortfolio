<?php

namespace App\Filament\Resources\SkillTypeResource\Pages;

use App\Filament\Resources\SkillTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSkillTypes extends ListRecords
{
    protected static string $resource = SkillTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
