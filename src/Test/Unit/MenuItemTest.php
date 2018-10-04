<?php

/**
 * Created by PhpStorm.
 * User: Dalton Whyte
 */
use PHPUnit\Framework\TestCase;
require __DIR__ . "/../../Models/MenuItem.php";

class MenuItemTest extends TestCase
{
    public function testName_WithName_ReturnsName()
    {
        $menuItem = new MenuItem();
        $menuItem->setName("Dalton Whyte");
        $this->assertEquals("Dalton Whyte", $menuItem->getName());
    }

}