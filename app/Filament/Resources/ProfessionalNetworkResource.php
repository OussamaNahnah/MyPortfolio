<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfessionalNetworkResource\Pages;
use App\Models\ProfessionalNetwork;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Validation\Rules\Unique;

class ProfessionalNetworkResource extends Resource
{
    protected static ?string $model = ProfessionalNetwork::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('link')->required()->url(),
                Toggle::make('isprincipal')
                ->onColor('success')
                ->offColor('danger')
                ->unique(callback: function (Unique $rule, callable $get) {
                    return $rule
                            ->where('isprincipal', true)
                            ->where('user_id', $get('user_id'));
                }, ignoreRecord: true)
                //->required()
                ,

                BelongsToSelect::make('user_id')->relationship('user', 'username')->required(),
                SpatieMediaLibraryFileUpload::make('icon')->collection('icon'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('user.username'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('link'),
                Tables\Columns\BooleanColumn::make('isprincipal')/*
                ->action(function ($record, $column) {
                    $name = $column->getName();
                    $record->update([
                        $name => ! $record->$name,
                    ]);
                })*/,
                SpatieMediaLibraryImageColumn::make('icon')->collection('icon'),

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
            'index' => Pages\ListProfessionalNetworks::route('/'),
            'create' => Pages\CreateProfessionalNetwork::route('/create'),
            'edit' => Pages\EditProfessionalNetwork::route('/{record}/edit'),
        ];
    }
}
