<?php

namespace App\Filament\Resources\SkillTypeResource\Pages;

use App\Filament\Resources\SkillTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSkillType extends EditRecord
{
    protected static string $resource = SkillTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
