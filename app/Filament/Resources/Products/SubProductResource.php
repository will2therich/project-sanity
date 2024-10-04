<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\SubProductResource\Pages;
use App\Filament\Resources\Products\SubProductResource\RelationManagers;
use App\Models\Products\SubProduct;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubProductResource extends Resource
{
    protected static ?string $model = SubProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function generateForm($subRecordId = 0)
    {
        return [
            Section::make('Basic Details')
                ->columns(2)
                ->schema([
                    Hidden::make('sub_product_group_id')
                        ->default($subRecordId),
                    TextInput::make('name')
                        ->columnSpan(2)
                        ->required(),
                    Toggle::make('flip_entire_image')
                        ->inline(false),
                    Toggle::make('conditionals_or_mode')
                        ->label('Run conditionals in \'Or\' mode')
                        ->inline(false),
                ]),
            Section::make('Imagery')
                ->columns(3)
                ->schema([
                    FileUpload::make('thumbnail_image'),
                    FileUpload::make('external_image'),
                    FileUpload::make('internal_image'),
                ]),
            Section::make('Pricing')
                ->columns(2)
                ->schema([
                    Select::make('pricing_type')
                        ->options([
                            1 => 'Fixed Uplift',
                            2 => 'Advanced Price Builder'
                        ])
                        ->required(),
                    TextInput::make('pricing_value'),
                ]),
            Section::make('Conditionals Setup')
                ->columns(1)
                ->schema([
                    Repeater::make('conditionals')
                        ->grid()
                        ->schema([])
                ])
        ];

    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::generateForm());
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
            'index' => SubProductResource\Pages\ListSubProducts::route('/'),
            'create' => SubProductResource\Pages\CreateSubProduct::route('/create'),
            'edit' => SubProductResource\Pages\EditSubProduct::route('/{record}/edit'),
        ];
    }
}
