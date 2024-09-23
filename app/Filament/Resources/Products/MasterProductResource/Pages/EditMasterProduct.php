<?php

namespace App\Filament\Resources\Products\MasterProductResource\Pages;

use App\Filament\Resources\Products\MasterProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasterProduct extends EditRecord
{
    protected static string $resource = MasterProductResource::class;

    public static function getNavigationLabel(): string
    {
        return 'Master Product Settings';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
