<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()  , 
                Forms\Components\TextInput::make('description')->required()  , 
                Forms\Components\TextInput::make('location')   , 
                Forms\Components\TextInput::make('link')->required()  ,  
                Select::make('skills')
                ->multiple()
                ->relationship('skills', 'name'),
                BelongsToSelect::make('user_id')->relationship('user', 'username')->required() ,
                SpatieMediaLibraryFileUpload::make('images')->multiple()->collection('images') ,
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
}
