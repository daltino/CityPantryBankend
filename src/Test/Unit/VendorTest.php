<?php

/**
 * Created by PhpStorm.
 * User: Dalton Whyte
 */
use PHPUnit\Framework\TestCase;
require __DIR__ . "/../../Models/Vendor.php";

class VendorTest extends TestCase
{
    public function testName_WithName_ReturnsName()
    {
        $vendor = new Vendor();
        $vendor->setName("SubWay");
        $this->assertEquals("SubWay", $vendor->getName());
    }

    public function testNull_WithName_ReturnsNull()
    {
        $vendor = new Vendor();
        $vendor->setName(null);
        $this->assertNull($vendor->getName());
    }

    public function testPostCode_With2PostCode_ReturnsPostCode(){
        $vendor = new Vendor();
        $vendor->setPostCode("NW352A");
        $this->assertEquals("NW352A", $vendor->getPostCode());
    }

    public function testMaxHeadCount_WithMaxHeadCount_ReturnsMaxHeadCount()
    {
        $vendor = new Vendor();
        $vendor->setMaxHeadCount("50");
        $this->assertEquals("50", $vendor->getMaxHeadCount());
    }

    public function testNull_WithWithMaxHeadCount_ReturnsNull()
    {
        $vendor = new Vendor();
        $vendor->setMaxHeadCount(null);
        $this->assertNull($vendor->getMaxHeadCount());
    }
}