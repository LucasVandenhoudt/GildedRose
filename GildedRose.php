<?php

declare(strict_types=1);

namespace GildedRose;

class GildedRose
{
    const AGEDBRIE = 'Aged Brie';
    const CONJURED = 'Conjured';
    const SULFURAS = 'Sulfuras, Hand of Ragnaros';
    const ERREUR = 'error';
    const QUALITEMAX = 50;
    const QUALITEMIN = 0;
    const BACKSTAGE = 'Backstage passes to a TAFKAL80ETC concert';
    const SELLINMIN=0;
    const NOMBRE_UPDATE_QUALITY_CONJURED = 2;
    const NOMBRE_UPDATE_QUALITY_DEFAULT = 1;
    const BACKSTAGE_INFERIEUR_OU_EGALE_A10 = 10;
    const BACKSTAGE_INFERIEUR_OU_EGALE_A5 = 5;
    const NOMBRE_UPDATE_SELLIN_DEFAULT=1;
    /**
     * @var Item[]
     */
    public $items;

    /**
     * @param array<int,Item> $items
     */
    public function __construct(array $items)
    {
        echo "salut:".get_class($this)."\n";
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->updateQualityOneItem($item);
        }
    }

    
    private function updateQualityOneItem(Item $item):void
    {
        $this->updateSellInPositif($item);
        $this->updateSellIn($item);
        $this->updateSellInNegatif($item);
    }

    private function updateQualityBackstageOrAgedBrie(Item $item):void
    {
        if ($item->name == self::BACKSTAGE) {
            if ($item->sell_in <= self::BACKSTAGE_INFERIEUR_OU_EGALE_A10) {
                if ($item->quality < self::QUALITEMAX) {
                    $item->quality = $item->quality + self::NOMBRE_UPDATE_QUALITY_DEFAULT;
                }
            }
            if ($item->sell_in <= self::BACKSTAGE_INFERIEUR_OU_EGALE_A5) {
                if ($item->quality < self::QUALITEMAX) {
                    $item->quality = $item->quality + self::NOMBRE_UPDATE_QUALITY_DEFAULT;
                }
            }
        }
    }

    private function updateSellInNegatif(Item $item):void
    {

        if ($item->sell_in < self::SELLINMIN) {
            if ($item->name == self::CONJURED) {
                $item->quality = $item->quality - self::NOMBRE_UPDATE_QUALITY_CONJURED;
            }
            if ($item->name == self::AGEDBRIE) {
                if ($item->quality < self::QUALITEMAX) {
                    $item->quality = $item->quality + self::NOMBRE_UPDATE_QUALITY_DEFAULT;
                }
            } else {
                $this->updateQualityIfSellInNegatif($item);
            }
        }
    }

    private function updateSellInPositif(Item $item):void
    {
        if ($this->checkItemNameDifferentAgedBrieBackstageConjured($item)) {
            $this->updateQualityIfSellInPositif($item);
        } else {
            if ($item->quality < self::QUALITEMAX) {
                $item->quality = $item->quality + self::NOMBRE_UPDATE_QUALITY_DEFAULT;
                $this->updateQualityBackstageOrAgedBrie($item);
            }
        }
    }

    private function checkItemNameDifferentAgedBrieBackstageConjured(Item $item):bool
    {
        return $item->name != self::AGEDBRIE and $item->name != self::BACKSTAGE and $item->name != self::CONJURED;
    }

    private function updateSellIn(Item $item):void
    {
        if ($item->name != self::SULFURAS) {
            $item->sell_in = $item->sell_in - self::NOMBRE_UPDATE_SELLIN_DEFAULT;
        }
    }

    private function updateQualityIfSellInNegatif(Item $item):void
    {
        if ($item->name != self::BACKSTAGE) {
            if ($item->quality > self::QUALITEMIN) {
                if ($item->name != self::SULFURAS) {
                    $item->quality = $item->quality - self::NOMBRE_UPDATE_QUALITY_DEFAULT;
                }
            }
        } else {
            $item->quality = 0;
        }
    }

    private function updateQualityIfSellInPositif(Item $item):void
    {
        if ($this->checkQualityEntre0Et50($item)) {
            if ($item->name != self::SULFURAS && $item->name != self::CONJURED) {
                $item->quality = $item->quality - self::NOMBRE_UPDATE_QUALITY_DEFAULT;
            }
        }
    }

    private function checkQualityEntre0Et50(Item $item):bool
    {
            return $item->quality > self::QUALITEMIN and $item->quality < self::QUALITEMAX;
    }
}
