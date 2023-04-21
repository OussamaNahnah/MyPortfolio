<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResponsibilityResource\Pages;
use App\Models\JobResponsibility;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class JobResponsibilityResource extends Resource
{
    protected static ?string $model = JobResponsibility::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        $ISADMIN = auth()->user()->isadmin;

        return $form
            ->schema([
                Forms\Components\TextInput::make('responsibility')->required()
                ->string()
                ->minLength(4)
                ->maxLength(255),

                BelongsToSelect::make('experience_id')
                ->relationship('experience', 'id', function ($query) use ($ISADMIN) {
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
                Tables\Columns\TextColumn::make('experience.name'),
                Tables\Columns\TextColumn::make('responsibility'),

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
            'index' => Pages\ListJobResponsibilities::route('/'),
            'create' => Pages\CreateJobResponsibility::route('/create'),
            'edit' => Pages\EditJobResponsibility::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->isadmin) {
            return parent::getEloquentQuery();
        } else {
            return parent::getEloquentQuery()->whereHas('experience', function ($q) {
                $q->where('experiences.user_id', auth()->user()->id);
            });
        }
    }
}
