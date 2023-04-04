<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResponsibilityResource\Pages;
use App\Filament\Resources\JobResponsibilityResource\RelationManagers;
use App\Models\JobResponsibility;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\BelongsToSelect;

class JobResponsibilityResource extends Resource
{
    protected static ?string $model = JobResponsibility::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('responsibility')->required()  ,  
                
                BelongsToSelect::make('experience_id')->relationship('experience', 'id')->required() 
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
}
