<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    /*test d'acceptation sur la méthode toString pour vérifier l'affichage*/
    public function testToString():void
    {
        $this->items = new Item('Conjured', 15, 9);
        $resultat=$this->items->__toString();
        $this->assertSame("Conjured, 15, 9", $resultat);
    }
}
