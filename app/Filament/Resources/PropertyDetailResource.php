<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyDetailResource\Pages;
use App\Filament\Resources\PropertyDetailResource\RelationManagers;
use App\Models\PropertyDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyDetailResource extends Resource
{
    protected static ?string $model = PropertyDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        /*        'area',
        'floor_number',
        'type_of_ownership',
        'number_of_rooms',
        'seller_type',
        'furnishing',
        'direction',
        'condition',
        'ad_id'*/
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('area')->searchable(),
                Tables\Columns\TextColumn::make('floor_number')->searchable(),
                Tables\Columns\TextColumn::make('type_of_ownership')->searchable(),
                Tables\Columns\TextColumn::make('number_of_rooms')->searchable(),
                Tables\Columns\TextColumn::make('seller_type')->searchable(),
                Tables\Columns\TextColumn::make('furnishing')->searchable(),
                Tables\Columns\TextColumn::make('direction')->searchable(),
                Tables\Columns\TextColumn::make('condition')->searchable(),
                Tables\Columns\TextColumn::make('ad_id')->sortable()->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPropertyDetails::route('/'),
            'edit' => Pages\EditPropertyDetail::route('/{record}/edit'),
        ];
    }
}
