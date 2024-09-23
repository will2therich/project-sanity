<?php

namespace App\Filament\Resources\Products\SubProductGroupsResource\Pages;

use App\Filament\Resources\Products\SubProductGroupsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubProductGroups extends EditRecord
{
    protected static string $resource = SubProductGroupsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
