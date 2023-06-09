<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillResource\Pages;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';


    protected static ?string $navigationGroup = 'Project Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $ISADMIN = auth()->user()->isadmin;

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()
                ->string()
                ->minLength(2)
                ->maxLength(255),

                BelongsToSelect::make('skill_type_id')
                ->relationship('skill_type', 'name')
                ->relationship('skill_type', 'name', function ($query) use ($ISADMIN) {
                    if ($ISADMIN) {
                        return $query;
                    }

                    return $query->where('user_id', auth()->user()->id);
                })
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('skill_type.name'),
                Tables\Columns\TextColumn::make('name'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSkills::route('/'),
            'create' => Pages\CreateSkill::route('/create'),
            'edit' => Pages\EditSkill::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->isadmin) {
            return parent::getEloquentQuery();
        } else {
            return parent::getEloquentQuery()->whereHas('skill_type', function ($q) {
                $q->where('skill_types.user_id', auth()->user()->id);
            });
        }
    }
}
