<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\Builder;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        $ISADMIN = auth()->user()->isadmin;

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()
                ->string()
                ->minLength(4)
                ->maxLength(255),
                Forms\Components\TextInput::make('description')->required()
                ->string()
                ->minLength(4)
                ->maxLength(255),
                Forms\Components\TextInput::make('link')
                ->string()
                ->minLength(4)
                ->maxLength(255),
                Select::make('skills')
                ->multiple()
                ->relationship('skills', 'name', function ($query) use ($ISADMIN) {
                    if ($ISADMIN) {
                        return $query;
                    }
                    $query->whereHas('skill_type', function ($query) {
                        return   $query->where('skill_types.user_id', auth()->user()->id);
                    });
                }),
                BelongsToSelect::make('user_id')
                ->relationship('user', 'username', function ($query) use ($ISADMIN) {
                    if ($ISADMIN) {
                        return $query;
                    }

                    return $query->where('id', auth()->user()->id);
                })
                ->required(),
                SpatieMediaLibraryFileUpload::make('images')->multiple()->collection('images'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('skills.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('link'),
                SpatieMediaLibraryImageColumn::make('images')->collection('images'),

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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->isadmin) {
            return parent::getEloquentQuery();
        } else {
            return parent::getEloquentQuery()->where('user_id', auth()->user()->id);
        }
    }
}
