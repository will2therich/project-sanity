<?php

namespace App\Filament\Resources\Products\MasterProductResource\Pages;

use App\Filament\Resources\Products\MasterProductResource;
use App\Helpers\Pages\ProductsPagesHelper;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class EditSubProductGroup extends Page
{
    use InteractsWithRecord;

    protected static string $resource = MasterProductResource::class;

    protected static string $view = 'filament.resources.products.master-product-resource.pages.edit-sub-product-group';
    protected static ?string $navigationLabel = 'Edit Sub-Product Groups';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static bool $shouldRegisterNavigation = false;
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function getSubNavigation(): array
    {
        return ProductsPagesHelper::getSubNavigation($this->getRecord());
    }

}
