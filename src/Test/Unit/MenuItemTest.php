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

    public function testNull_WithName_ReturnsNull()
    {
        $menuItem = new MenuItem();
        $menuItem->setName(null);
        $this->assertNull($menuItem->getName());
    }

    public function testAllergies_With2Allergies_Returns2(){
        $menuItem = new MenuItem();
        $menuItem->setAllergies(['Egg','Fish']);
        $this->assertCount(2, $menuItem->getAllergies());
    }

    public function testNoticePeriod_WithNoticePeriod_ReturnsNoticePeriod()
    {
        $menuItem = new MenuItem();
        $menuItem->setNoticePeriod("12h");
        $this->assertEquals("12h", $menuItem->getNoticePeriod());
    }

    public function testNull_WithWithNoticePeriod_ReturnsNull()
    {
        $menuItem = new MenuItem();
        $menuItem->setNoticePeriod(null);
        $this->assertNull($menuItem->getNoticePeriod());
    }


}