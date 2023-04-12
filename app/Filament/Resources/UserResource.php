<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Support\Facades\Hash; 
use Filament\Forms\Components\DatePicker;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {         
        return $form
            ->schema([
                Forms\Components\TextInput::make('username')->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('fullname')->required(),
                DatePicker::make('birthday')->required(), 
                Forms\Components\TextInput::make('email')->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('location')->required(),              
                Forms\Components\TextInput::make('password') ->password()->minLength(6)
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ->dehydrated(fn ($state) => filled($state))   
                ->required(fn (string $context): bool => $context === 'create'),
                TinyEditor::make('bio')->required()  , 
                SpatieMediaLibraryFileUpload::make('image')->collection('image'),
            ]); 
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),    
                Tables\Columns\TextColumn::make('username'),    
                Tables\Columns\TextColumn::make('fullname'),
                Tables\Columns\TextColumn::make('bio'),
                Tables\Columns\TextColumn::make('birthday'),  
                Tables\Columns\TextColumn::make('email'), 
                Tables\Columns\TextColumn::make('location'),  
                SpatieMediaLibraryImageColumn::make('image')->collection('image'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('Download Cv Pdf')
                ->icon('heroicon-o-document-download')
                ->url(fn (User $record) => route('cv', $record->id))
                ->openUrlInNewTab(),

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
                'index' => Pages\ListUsers::route('/'),
                'create' => Pages\CreateUser::route('/create'),
                'edit' => Pages\EditUser::route('/{record}/edit'),
            ]; 
       
    } 
       /*public static function getEloquentQuery(): Builder
    {if(auth()->user()->isadmin){
        return parent::getEloquentQuery();
    }else{
        return parent::getEloquentQuery()->where('id',auth()->user()->id);
    }
        
    }*/
}
