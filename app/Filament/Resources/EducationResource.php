<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducationResource\Pages;
use App\Filament\Resources\EducationResource\RelationManagers;
use App\Models\Education;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\BelongsToSelect;

use Filament\Forms\Components\DatePicker;

class EducationResource extends Resource
{
    protected static ?string $model = Education::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nameschool')->required(),
                Forms\Components\TextInput::make('specialization')->required()  ,
                DatePicker::make('startdate')->required(), 
                DatePicker::make('enddate')->required(), 
                BelongsToSelect::make('user_id')->relationship('user', 'username')->required(),
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
}
