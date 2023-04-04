<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillTypeResource\Pages;
use App\Filament\Resources\SkillTypeResource\RelationManagers;
use App\Models\SkillType;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\BelongsToSelect;

class SkillTypeResource extends Resource
{
    protected static ?string $model = SkillType::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()  ,  
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
            'index' => Pages\ListSkillTypes::route('/'),
            'create' => Pages\CreateSkillType::route('/create'),
            'edit' => Pages\EditSkillType::route('/{record}/edit'),
        ];
    }    
}
