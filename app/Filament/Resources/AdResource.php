<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
use App\Filament\Resources\AdResource\RelationManagers;
use App\Models\Ad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('location')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('offer_type')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type_ad')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user_id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category_id')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListAds::route('/'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }
}
