<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /*test d'acceptation sur l'erreur si la qualité est négative*/
    public function testQualiteNegative(): void
    {
        $items = [new Item('Produit', 5, -1)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(-1, $items[0]->quality);
    }

    /*test d'acceptation sur l'augmentation de la qualité de l'objet Aged Brie*/
    public function testQualiteAgedBrie(): void
    {
        $items = [new Item('Aged Brie', -1, 45)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(47, $items[0]->quality);
    }

    /*test d'acceptation sur l'erreur si la qualité est supérieur à 50*/
    public function testQualiteSupperieur50(): void
    {
        $items = [new Item('Produit', 5, 51)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(51, $items[0]->quality);
    }

    /*test d'acceptation sur la qualité de l'objet Sulfura*/
    public function testSulfuraQuality(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 10, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(30, $items[0]->quality);
    }

    /*test d'acceptation sur le sellIn de l'objet Sulfura*/
    public function testSulfuraSellIn(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 10, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(10, $items[0]->sell_in);
    }

    /*test d'acceptation sur la qualité de l'objet Backstage quand il est compris entre 5 et 9*/
    public function testBackstageInferieur10(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 9, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(32, $items[0]->quality);
    }

    /*test d'acceptation sur la qualité de l'objet Backstage quand il est compris entre 1 et 4*/
    public function testBackstageInferieur5(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 4, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(33, $items[0]->quality);
    }
    
    /*test d'acceptation sur la qualité de l'objet Backstage quand il est négatif*/
    public function testBackstageNegatif(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', -1, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(0, $items[0]->quality);
    }

    /*test d'acceptation sur la qualité d'un objet crée dont la qualité est inférieur à 50*/
    public function testProduit(): void
    {
        $items = [new Item('Produit', 3, 29)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(28, $items[0]->quality);
    }

    /*test d'acceptation sur le sellIn d'un objet crée dont le sellIn est négatif*/
    public function testProduitQualite(): void
    {
        $items = [new Item('Produit', -1, 29)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(27, $items[0]->quality);
    }

    /*test d'acceptation sur la qualité d'un objet Conjured dont le sellIn est négatif*/
    public function testQualiteConjuredN(): void
    {
        $items = [new Item('Conjured', -1, 44), ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(42, $items[0]->quality);
    }
}
