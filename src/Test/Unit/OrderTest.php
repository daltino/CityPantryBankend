<?php

/**
 * Created by PhpStorm.
 * User: Dalton Whyte
 */

use PHPUnit\Framework\TestCase;
require __DIR__ . "/../../Models/Order.php";

class OrderTest extends TestCase
{
    public function testVendorFile_WithVendorFile_ReturnsVendorFile()
    {
        $order = new Order();
        $order->setVendorFile("vendors-data");
        $this->assertEquals("vendors-data", $order->getVendorFile());
    }

    public function testNull_WithVendorFile_ReturnsNull()
    {
        $order = new Order();
        $order->setVendorFile(null);
        $this->assertNull($order->getVendorFile());
    }

    public function testSearchForMenuItems_WithOrderDetails_ReturnsMenuItems()
    {
        $order = new Order();
        $order->setVendorFile("vendors-data");
        $order->setDay("05/10/18");
        $order->setTime("18:00");
        $order->setLocation("E32NY");
        $order->setCovers(50);
        $this->assertJsonStringEqualsJsonString('["Grain salad;nuts;", "Fried Rice and chicken;salad;"]',
            $order->searchForMenuItems());
    }
}