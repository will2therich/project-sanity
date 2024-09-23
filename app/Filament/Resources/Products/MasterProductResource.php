<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\MasterProductResource\Pages;
use App\Filament\Resources\MasterProductResource\RelationManagers;
use App\Filament\Resources\Products\MasterProductResource\Pages\EditMasterProduct;
use App\Filament\Resources\Products\MasterProductResource\Pages\EditSubProductGroup;
use App\Filament\Resources\Products\MasterProductResource\Pages\SubProductGroups;
use App\Helpers\Pages\ProductsPagesHelper;
use App\Models\Products\MasterProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MasterProductResource extends Resource
{
    protected static ?string $model = MasterProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'E-Commerce';

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems(ProductsPagesHelper::PRODUCT_PAGE_CLASSES);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General Info')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#'),
                Tables\Columns\TextColumn::make('name')
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
            'index' => MasterProductResource\Pages\ListMasterProducts::route('/'),
            'create' => MasterProductResource\Pages\CreateMasterProduct::route('/create'),
            'edit' => MasterProductResource\Pages\EditMasterProduct::route('/{record}/edit'),
            'subgroups' => SubProductGroups::route('/{record}/sub-groups'),
            'edit-subgroup' => EditSubProductGroup::route('/{record}/sub-groups/{subRecord?}')
        ];
    }
}
