<?php

namespace App\Filament\Resources\Products\SubProductResource\Pages;

use App\Filament\Resources\Products\SubProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubProducts extends ListRecords
{
    protected static string $resource = SubProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
