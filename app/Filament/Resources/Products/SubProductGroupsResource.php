<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products;
use App\Filament\Resources\SubProductGroupsResource\Pages;
use App\Filament\Resources\SubProductGroupsResource\RelationManagers;
use App\Models\Products\SubProductGroups;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubProductGroupsResource extends Resource
{
    protected static ?string $model = SubProductGroups::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Products\SubProductGroupsResource\Pages\ListSubProductGroups::route('/'),
            'create' => Products\SubProductGroupsResource\Pages\CreateSubProductGroups::route('/create'),
            'edit' => Products\SubProductGroupsResource\Pages\EditSubProductGroups::route('/{record}/edit'),
        ];
    }
}
