<?php

namespace App\Filament\Resources\Products\MasterProductResource\Pages;

use App\Filament\Resources\Products\MasterProductResource;
use App\Filament\Resources\Products\SubProductResource;
use App\Helpers\Pages\ProductsPagesHelper;
use App\Models\Products\SubProduct;
use App\Models\Products\SubProductGroups as SubProductGroupModel;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EditSubProductGroup extends Page implements HasTable
{
    use InteractsWithRecord, InteractsWithForms, InteractsWithTable;

    protected static string $resource = MasterProductResource::class;

    protected static string $view = 'filament.resources.products.master-product-resource.pages.edit-sub-product-group';
    protected static ?string $navigationLabel = 'Edit Sub-Product Groups';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static bool $shouldRegisterNavigation = false;

    protected \App\Models\Products\SubProductGroups $subRecord;

    protected $selectedVariantId;

    public function mount(int | string $record, $subRecord, $selectedVariantId): void
    {
        $this->subRecord = \App\Models\Products\SubProductGroups::find($subRecord);
        $this->record = $this->resolveRecord($record);
        $this->selectedVariantId = $selectedVariantId;

        $this->form->fill([
            'name' => $this->subRecord->name
        ]);
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
        ]);
    }

    protected function getTableQuery()
    {
        return SubProduct::query()
            ->where('sub_product_group_id', $this->getRecord()->id);
    }

    public function getSubRecordId($uri = '')
    {
        if (empty($uri)) {
            $req = Request::createFromGlobals();
            $uri = $req->getUri();
        }

        $url_path = parse_url($uri, PHP_URL_PATH);
        $basename = pathinfo($url_path, PATHINFO_BASENAME);

        return $basename;
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name'),
            TextColumn::make('uuid')
        ];
    }

    protected function getHeaderActions() : array
    {
        $record = $this->getRecord();
        $subRecordId = $this->getSubRecordId($_SERVER['HTTP_REFERER']);

        return [
            Action::make('Create New Sub Product')
                ->form(SubProductResource::generateForm())
                ->action(function ($data) use ($record, $subRecordId) {
                    $data['product_id'] = $record->id;
                    $data['uuid'] = Str::uuid();
                    $data['sub_product_group_id'] = $subRecordId;
                    SubProduct::create($data);
                })
        ];
    }


}
