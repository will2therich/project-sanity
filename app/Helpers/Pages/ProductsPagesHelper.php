<?php

namespace App\Helpers\Pages;

use App\Filament\Resources\Products\MasterProductResource\Pages\EditMasterProduct;
use App\Filament\Resources\Products\MasterProductResource\Pages\SubProductGroups;
use Filament\Navigation\NavigationItem;

class ProductsPagesHelper
{

    public const PRODUCT_PAGE_CLASSES = [
      EditMasterProduct::class,
      SubProductGroups::class
    ];

    public static function getSubNavigation($record)
    {
        $returnArr = [];

        foreach (self::PRODUCT_PAGE_CLASSES as $class) {
            $classInst = app($class);
            $returnArr[] =NavigationItem::make($classInst::getNavigationLabel())
                ->url($classInst::getUrl(['record' => $record->id]))
                ->icon($classInst::getNavigationIcon())
                ->isActiveWhen(function () use ($classInst) {
                    return request()->routeIs($classInst::getRouteName());
                })
                ->visible(true);
        }

        return $returnArr;

    }

}
