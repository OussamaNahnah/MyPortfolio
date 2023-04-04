<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhoneNumberResource\Pages;
use App\Filament\Resources\PhoneNumberResource\RelationManagers;
use App\Models\PhoneNumber;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\BelongsToSelect;

class PhoneNumberResource extends Resource
{
    protected static ?string $model = PhoneNumber::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('numberphone')->required()  , 
                BelongsToSelect::make('user_id')->relationship('user', 'username')->required() ,
            ]);
    }

    public static function table(Table $table): Table
    {  
             
      
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),    
                Tables\Columns\TextColumn::make('user.username'), 
                Tables\Columns\TextColumn::make('numberphone'),  
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
            'index' => Pages\ListPhoneNumbers::route('/'),
            'create' => Pages\CreatePhoneNumber::route('/create'),
            'edit' => Pages\EditPhoneNumber::route('/{record}/edit'),
        ];
    }    
}
