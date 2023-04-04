<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceResource\Pages;
use App\Filament\Resources\ExperienceResource\RelationManagers;
use App\Models\Experience;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\BelongsToSelect;

use Filament\Forms\Components\DatePicker;
class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {  return $form
        ->schema([
            Forms\Components\TextInput::make('name')->required()  , 
            Forms\Components\TextInput::make('titlejob')->required()  , 
            Forms\Components\TextInput::make('location')->required()  , 
            DatePicker::make('startdate')->required(), 
            DatePicker::make('enddate')->required(), 
            BelongsToSelect::make('user_id')->relationship('user', 'username')->required() ,
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
   
}
