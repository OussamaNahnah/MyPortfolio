<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceResource\Pages;
use App\Models\Experience;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Experience Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $ISADMIN = auth()->user()->isadmin;

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()
                ->string()
                ->minLength(4)
                ->maxLength(255),
                Forms\Components\TextInput::make('titlejob')->required()
                ->string()
                ->minLength(4)
                ->maxLength(255),
                Forms\Components\TextInput::make('location')->required()
                ->string()
                ->minLength(4)
                ->maxLength(255),
                Forms\Components\TextInput::make('startdate')->required()->rules('date_format:Y-m'),
                Forms\Components\TextInput::make('enddate')->rules('date_format:Y-m|nullable'),
                BelongsToSelect::make('user_id')
               ->relationship('user', 'username', function ($query) use ($ISADMIN) {
                   if ($ISADMIN) {
                       return $query;
                   }

                   return $query->where('id', auth()->user()->id);
               })
                ->required(),
            ]);
    }

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('user.username'),
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('titlejob'),
            Tables\Columns\TextColumn::make('location'),
            Tables\Columns\TextColumn::make('startdate'),
            Tables\Columns\TextColumn::make('enddate'),
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
            'index' => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit' => Pages\EditExperience::route('/{record}/edit'),
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
