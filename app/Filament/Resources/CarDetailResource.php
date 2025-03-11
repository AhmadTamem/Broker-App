<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarDetailResource\Pages;
use App\Filament\Resources\CarDetailResource\RelationManagers;
use App\Models\CarDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarDetailResource extends Resource
{
    protected static ?string $model = CarDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        /*
        'car_condition',
        'make',
        'vehicle_class',
        'transmission',
        'manufacturing_year',
        'kilometers',
        'color',
        'fuel',
        'engine_capacity',
        'seller_type',
        'ad_id'
        */
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('car_condition')->searchable(),
                Tables\Columns\TextColumn::make('make')->searchable(),
                Tables\Columns\TextColumn::make('vehicle_class')->searchable(),
                Tables\Columns\TextColumn::make('transmission')->searchable(),
                Tables\Columns\TextColumn::make('manufacturing_year')->searchable(),
                Tables\Columns\TextColumn::make('kilometers')->searchable(),
                Tables\Columns\TextColumn::make('color')->searchable(),
                Tables\Columns\TextColumn::make('fuel')->searchable(),
                Tables\Columns\TextColumn::make('engine_capacity')->searchable(),
                Tables\Columns\TextColumn::make('seller_type')->searchable(),
                Tables\Columns\TextColumn::make('ad_id')->sortable()->searchable(),
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
            'index' => Pages\ListCarDetails::route('/'),
            'edit' => Pages\EditCarDetail::route('/{record}/edit'),
        ];
    }
}
