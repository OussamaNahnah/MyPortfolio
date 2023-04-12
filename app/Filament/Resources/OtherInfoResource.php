<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OtherInfoResource\Pages;
use App\Filament\Resources\OtherInfoResource\RelationManagers;
use App\Models\OtherInfo;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\BelongsToSelect; 



class OtherInfoResource extends Resource
{
    protected static ?string $model = OtherInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([ 
                Forms\Components\TextInput::make('description')->required(),      
                BelongsToSelect::make('user_id')->relationship('user', 'username')->required()->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {  
             
      
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),    
                Tables\Columns\TextColumn::make('user.username'), 
                Tables\Columns\TextColumn::make('description'),  
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
            'index' => Pages\ListOtherInfos::route('/'),
            'create' => Pages\CreateOtherInfo::route('/create'),
            'edit' => Pages\EditOtherInfo::route('/{record}/edit'),
        ];
    }    
}
