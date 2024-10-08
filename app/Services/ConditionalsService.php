<?php

namespace App\Services;

use App\Models\Products\SubProduct;
use App\Models\Products\SubProductGroups;
use App\Models\ProductVariantLayers;
use App\Models\ProductVariantLayersOptions;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class ConditionalsService
{
    public $conditionalClasses = [];

    public $record;

    public function __construct($record)
    {
        $this->conditionalClasses = $this->getConditionals();
        $this->record = $record;
    }

    public function getConditionals()
    {
        $conditionals = [];

        $path = is_dir(app_path('Services/Conditionals')) ? app_path('Services/Conditionals') : app_path();
        $namespace = app()->getNamespace();

        foreach ((new Finder)->in($path)->files() as $model) {
            $model = $namespace . str_replace(
                    ['/', '.php'], ['\\', ''], Str::after($model->getRealPath(), realpath(app_path()) . DIRECTORY_SEPARATOR)
                );

            $modelObj = app($model);

            if ($modelObj::CONDITIONAL_NAME !== null) {
                $conditionals[$modelObj::CONDITIONAL_ID] = [
                    'class' => $modelObj::class
                ];
            }
        }

        return $conditionals;
    }

    public function generateConditionalsForm()
    {
        $formArr = [];
        $registeredFields = [];
        $dynamicFormArr = [];
        $conditionalOptions = [];

        // Default Conditional Fields
        $formArr[] = Select::make('conditional_field')
            ->searchable()
            ->options(SubProductGroups::query()->where('product_id', $this->record->id)->take(10)->pluck('name', 'id'))
            ->getSearchResultsUsing(fn (string $search) => SubProductGroups::query()->where('name', 'like', "%{$search}%")->where('variant_id', $this->record->variant_id)->take(50)->pluck('name', 'id'))
            ->getOptionLabelUsing(fn ($value): ?string => SubProductGroups::find($value)?->name)
            ->reactive();

        $formArr[] = Select::make('Options')
            ->multiple()
            ->options(function (callable $get) {
                $option = $get('conditional_field');

                $possibleOptions = SubProduct::query()->where('sub_product_group_id', $option)->pluck('name', 'id');

                if (empty($possibleOptions)) {
                    return [
                        0 => 'Please Select a Field'
                    ];
                } else {
                    return $possibleOptions;
                }
            });



        // Dynamically create fields

        foreach ($this->conditionalClasses as $conditionalClass) {
            $classInstance = app($conditionalClass['class']);
            $conditionalOptions[$classInstance::CONDITIONAL_ID] = $classInstance::CONDITIONAL_NAME;

            if (method_exists($classInstance, 'form')) {
                $classInstance->form($dynamicFormArr, $registeredFields);
            }
        }

        $formArr[] = Select::make('conditional_type')
                ->options($conditionalOptions)
                ->reactive();


        $formArr = array_merge($formArr, $dynamicFormArr);
        return $formArr;

    }
}
