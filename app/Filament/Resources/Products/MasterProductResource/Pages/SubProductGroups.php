<?php

namespace App\Filament\Resources\Products\MasterProductResource\Pages;

use App\Filament\Resources\Products\MasterProductResource;
use App\Helpers\Pages\ProductsPagesHelper;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Pages\Page;

class SubProductGroups extends Page
{
    use InteractsWithRecord;

    protected static string $resource = MasterProductResource::class;

    protected static ?string $navigationLabel = 'Sub-Product Groups';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string $view = 'filament.resources.products.master-product-resource.pages.sub-product-groups';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function getSubNavigation(): array
    {
        return ProductsPagesHelper::getSubNavigation($this->getRecord());
    }
}
