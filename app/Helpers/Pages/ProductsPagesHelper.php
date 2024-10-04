<?php

namespace App\Helpers\Pages;

use App\Filament\Resources\Products\MasterProductResource\Pages\EditMasterProduct;
use App\Filament\Resources\Products\MasterProductResource\Pages\EditSubProductGroup;
use App\Filament\Resources\Products\MasterProductResource\Pages\MasterProductVariants;
use App\Filament\Resources\Products\MasterProductResource\Pages\SubProductGroups;
use Filament\Navigation\NavigationItem;

class ProductsPagesHelper
{

    public const PRODUCT_PAGE_CLASSES = [
        EditMasterProduct::class,
        MasterProductVariants::class,
        SubProductGroups::class,
        EditSubProductGroup::class
    ];


    /**
     * Retrieves the sub navigation items for the product pages, needs a record for route gen
     *
     * @param mixed $record The record to use for route generation
     *
     * @return NavigationItem[] The array of sub navigation items.
     */
    public static function getSubNavigation($record, $variantId = 0)
    {
        $returnArr = [];

        foreach (self::PRODUCT_PAGE_CLASSES as $class) {
            $classInst = app($class);
            $navItem = NavigationItem::make($classInst::getNavigationLabel());
            $subRecord = 1;
            $variantId = 0;

            if ($class == EditSubProductGroup::class) {
                $subRecord = request()->route()->parameter('subRecord');
                $navItem->hidden(function () use ($classInst) {
                    $isRoute = request()->routeIs($classInst::getRouteName());
                    if ($isRoute) return false;
                    return true;
                });
            }

            if ($class == SubProductGroups::class) {
                $variantId = request()->route()->parameter('selectedVariantId');
                if ($variantId == null) {
                    $navItem->hidden(function () {
                        return true;
                    });
                }
            }

            $navItem->url($classInst::getUrl(['record' => $record->id, 'subRecord' => $subRecord, 'selectedVariantId' => $variantId]))
                ->icon($classInst::getNavigationIcon())
                ->isActiveWhen(function () use ($classInst) {
                    return request()->routeIs($classInst::getRouteName());
                })
                ->visible(true);

            $returnArr[] = $navItem;
        }

        return $returnArr;

    }

}
