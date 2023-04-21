<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OtherInfoResource\Pages;
use App\Models\OtherInfo;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class OtherInfoResource extends Resource
{
    protected static ?string $model = OtherInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        $ISADMIN = auth()->user()->isadmin;

        return $form
            ->schema([
                Forms\Components\TextInput::make('description')->required()
                ->string()
                ->minLength(4)
                ->maxLength(255),
                BelongsToSelect::make('user_id')
                ->relationship('user', 'username', function ($query) use ($ISADMIN) {
                    if ($ISADMIN) {
                        return $query;
                    }

                    return $query->where('id', auth()->user()->id);
                })
                ->required()
                ->unique(ignoreRecord: true),
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

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->isadmin) {
            return parent::getEloquentQuery();
        } else {
            return parent::getEloquentQuery()->where('user_id', auth()->user()->id);
        }
    }
}
