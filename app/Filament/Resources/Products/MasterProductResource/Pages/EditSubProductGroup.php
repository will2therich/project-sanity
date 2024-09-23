<?php

namespace App\Filament\Resources\Products\MasterProductResource\Pages;

use App\Filament\Resources\Products\MasterProductResource;
use App\Helpers\Pages\ProductsPagesHelper;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class EditSubProductGroup extends Page
{
    use InteractsWithRecord, InteractsWithForms;

    protected static string $resource = MasterProductResource::class;

    protected static string $view = 'filament.resources.products.master-product-resource.pages.edit-sub-product-group';
    protected static ?string $navigationLabel = 'Edit Sub-Product Groups';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static bool $shouldRegisterNavigation = false;

    protected $subRecord;
    public function mount(int | string $record, $subRecord): void
    {
        $this->subRecord = \App\Models\Products\SubProductGroups::find($subRecord);
        $this->record = $this->resolveRecord($record);
    }

    public function getSubNavigation(): array
    {
        return ProductsPagesHelper::getSubNavigation($this->getRecord());
    }

    public function form(Form $form): Form
    {
        return $form->schema([
           Section::make('Sub-Group Details')->schema([
               TextInput::make('name'),
           ]),
            Section::make('Products')->schema([
                Repeater::make('Products')
                    ->grid()
                    ->columns(2)
            ])
        ]);
    }

}
