<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRoseQualityIssue;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseQualityIssueTest extends TestCase
{
    public function testAjouterTrois():void
    {
        /** @var array<int|string,TYPE>$item */
        $items = [
            new Item('Aged Brie', 4, 30),
            new Item('Backstage passes to a TAFKAL80ETC concert', 4, 30),
            new Item('Aged Brie', -1, 30),
            new Item('Aged Brie', 4, 51),
        ];   
        $gildedrose=new GildedRoseQualityIssue($items);
        $gildedrose->updateQuality();
        $this->assertSame(33, $items[0]->quality);
        $this->assertSame(33, $items[1]->quality);
        $this->assertSame(30, $items[2]->quality);
        $this->assertSame(51, $items[3]->quality);
    }
    public function testAjouterDeuxBackstage():void
    {
        $items = [
            new Item('Backstage passes to a TAFKAL80ETC concert', 7, 15),
            new Item('Aged Brie', 7, 19),
            new Item('Aged Brie', -1, 19)
        ];
        $gildedrose=new GildedRoseQualityIssue($items);
        $gildedrose->updateQuality();
        $this->assertSame(17, $items[0]->quality);
        $this->assertSame(21, $items[1]->quality);
        $this->assertSame(19, $items[2]->quality);
    }

    public function testEnleverDeux():void
    {
        $items = [new Item('Conjured', 4, 15)];
        $gildedrose=new GildedRoseQualityIssue($items);
        $gildedrose->updateQuality();
        $this->assertSame(13, $items[0]->quality);
    }

    public function testUpdateSellIn():void
    {
        $items = [
            new Item('Conjured', 4, 15),
            new Item(GildedRoseQualityIssue::SULFURAS, 4, 15)
        ];
        $gildedrose=new GildedRoseQualityIssue($items);
        $gildedrose->updateQuality();
        $this->assertSame(3, $items[0]->sell_in);
        $this->assertSame(4, $items[1]->sell_in);
    }
    
    public function testAjouterUn():void
    {
        $items = [
            new Item(GildedRoseQualityIssue::BACKSTAGE, 15, 15),
            new Item(GildedRoseQualityIssue::AGEDBRIE, 15, 15)
        ];
        $gildedrose=new GildedRoseQualityIssue($items);
        $gildedrose->updateQuality();
        $this->assertSame(16, $items[0]->quality);
        $this->assertSame(16, $items[1]->quality);
    }

    public function testEnleverUn():void
    {
        $items = [
            new Item('Produit', 15, 15),
            new Item('Aged Brie', -1, 15)
        ];
        $gildedrose=new GildedRoseQualityIssue($items);
        $gildedrose->updateQuality();
        $this->assertSame(14, $items[0]->quality);
        $this->assertSame(15, $items[1]->quality);
    }
}

