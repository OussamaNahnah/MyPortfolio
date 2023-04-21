<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducationResource\Pages;
use App\Models\Education;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class EducationResource extends Resource
{
    protected static ?string $model = Education::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        $ISADMIN = auth()->user()->isadmin;

        return $form
            ->schema([
                Forms\Components\TextInput::make('nameschool')->required()
                ->string()
                ->minLength(4)
                ->maxLength(255),
                Forms\Components\TextInput::make('specialization')->required()
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
                Tables\Columns\TextColumn::make('nameschool'),
                Tables\Columns\TextColumn::make('specialization'),
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
            'index' => Pages\ListEducation::route('/'),
            'create' => Pages\CreateEducation::route('/create'),
            'edit' => Pages\EditEducation::route('/{record}/edit'),
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
