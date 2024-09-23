<?php

namespace App\Filament\Resources\Products\MasterProductResource\Pages;

use App\Filament\Resources\Products\MasterProductResource;
use App\Helpers\Pages\ProductsPagesHelper;
use Filament\Support\Colors\Color;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use App\Models\Products\SubProductGroups as SubProductGroupModel;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Str;

class SubProductGroups extends Page implements HasTable
{
    use InteractsWithRecord, InteractsWithTable;

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

    protected function getHeaderActions() : array
    {
        $record = $this->getRecord();

        return [
            Action::make('Create New Sub Group')
                ->form([
                    TextInput::make('group_name')
                        ->required()
                ])
                ->action(function ($data) use ($record) {
                    if (isset($data['group_name'])) {
                        SubProductGroupModel::create([
                            'name' => $data['group_name'],
                            'product_id' => $record->id,
                            'uuid' => Str::uuid()
                        ])->save();
                    }
                })
        ];
    }


    protected function getTableQuery()
    {
        return SubProductGroupModel::query()
            ->where('product_id', $this->getRecord()->id);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name'),
        ];
    }

    protected function getTableActions()
    {
        $parentRecord = $this->getRecord();

        return [
            \Filament\Tables\Actions\Action::make('Edit')
                ->url(function ($record) use ($parentRecord){
                    return EditSubProductGroup::getUrl([
                        'record' => $parentRecord->id,
                        'subRecord' => $record->id
                    ]);
                }),
            \Filament\Tables\Actions\Action::make('Delete')
                ->requiresConfirmation()
                ->color(Color::Red)
                ->action(function ($record) {
                    $record->delete();
                })
        ];
    }
}
