<?php

namespace App\Filament\Resources\Products\MasterProductResource\Pages;

use App\Filament\Resources\Products\MasterProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasterProducts extends ListRecords
{
    protected static string $resource = MasterProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
