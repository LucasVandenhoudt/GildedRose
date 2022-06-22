<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Item;

final class GildedRoseQualityIssue extends GildedRose
{

    public function updateQuality():void
    {

        foreach ($this->items as $item) {
            $this->augmenterUn($item);
            $this->augmenterDeux($item);
            $this->augmenterTrois($item);
            $this->enleverUn($item);
            $this->enleverDeux($item);
            $this->updateSellIn($item);
        }
    }

    private function augmenterUn(Item $item):bool
    {
        if ($item->name == self::BACKSTAGE && $item->sell_in>self::BACKSTAGE_INFERIEUR_OU_EGALE_A10
        && $item->quality < self::QUALITEMAX ||
        $item->name == self::AGEDBRIE && $item->sell_in>self::BACKSTAGE_INFERIEUR_OU_EGALE_A10
        && $item->quality < self::QUALITEMAX) {
            $item->quality++;
            return true;
        }
        return false;
    }

    private function augmenterDeux(Item $item):bool
    {
        if ($item->name==self::BACKSTAGE && $item->sell_in<=self::BACKSTAGE_INFERIEUR_OU_EGALE_A10
        && $item->sell_in>self::BACKSTAGE_INFERIEUR_OU_EGALE_A5 && $item->quality<self::QUALITEMAX
        || $item->name==self::AGEDBRIE && $item->sell_in<=self::BACKSTAGE_INFERIEUR_OU_EGALE_A10
        && $item->sell_in>self::BACKSTAGE_INFERIEUR_OU_EGALE_A5
        && $item->quality<self::QUALITEMAX) {
            $item->quality= $item->quality + 2;
            return true;
        }
        return false;
    }

    private function augmenterTrois(Item $item):bool
    {
        if ($item->name==self::BACKSTAGE && $item->sell_in<=self::BACKSTAGE_INFERIEUR_OU_EGALE_A5
        && $item->sell_in>self::SELLINMIN
        && $item->quality<self::QUALITEMAX
        || $item->name==self::AGEDBRIE && $item->sell_in<=self::BACKSTAGE_INFERIEUR_OU_EGALE_A5
        && $item->sell_in>self::SELLINMIN
        && $item->quality<self::QUALITEMAX) {
            $item->quality= $item->quality + 3;
            return true;
        }
        return false;
    }

    private function enleverUn(Item $item):bool
    {
        if ($item->name != self::AGEDBRIE and $item->name != self::BACKSTAGE && $item->quality > self::QUALITEMIN
        && $item->name != self::SULFURAS && $item->name != self::CONJURED ||
        $item->sell_in < self::SELLINMIN && $item->name != self::AGEDBRIE && $item->name != self::BACKSTAGE
        && $item->quality > self::QUALITEMIN && $item->name != self::SULFURAS && $item->name != self::CONJURED) {
            $item->quality = $item->quality - 1;
            return true;
        }
        return false;
    }

    private function enleverDeux(Item $item):bool
    {
        if ($item->name==self::CONJURED && $item->quality<self::QUALITEMAX && $item->sell_in>self::SELLINMIN
        || $item->sell_in<self::SELLINMIN && $item->name==self::CONJURED && $item->quality<self::QUALITEMAX) {
            $item->quality= $item->quality - 2;
            return true;
        }
        return false;
    }

    private function updateSellIn(Item $item):bool
    {
        if ($item->name != self::SULFURAS) {
            $item->sell_in = $item->sell_in - self::NOMBRE_UPDATE_SELLIN_DEFAULT;
            return true;
        }
        return false;
    }
}
