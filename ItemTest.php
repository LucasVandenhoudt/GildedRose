<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    /*test d'acceptation sur la méthode toString pour vérifier l'affichage*/
    public function testToString():void
    {
        $item = new Item('Conjured', 15, 9);
        $resultat=$item->__toString();
        $this->assertSame("Conjured, 15, 9", $resultat);
    }
}
