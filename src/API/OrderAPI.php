<?php

/**
 * Created by PHPStorm.
 * User: Dalton Whyte
 */
require_once __DIR__ . "/../Models/Order.php";

class OrderAPI
{
    /*
     * The default search function for finding
     * menuitems that match a users search.
     *
     * @param string $filename, input file with vendors data
     * @param string $day, delivery day (dd/mm/yy)
     * @param string $time, delivery time (hh:mm)
     * @param string $location, delivery location without spaces (Ex. NW42QA)
     * @param int $covers, number of people to feed
     *
     * @return string, JSON string containing menu item name and their allergens
     */
    public function search($filename, $day, $time, $location, $covers)
    {
        // Initialize the order object
        $order = new Order();
        $order->setVendorFile($filename);
        $order->setDay($day);
        $order->setTime($time);
        $order->setLocation($location);
        $order->setCovers($covers);

        // Query the vendors data for menuitems
        $menuitems = $order->searchForMenuItems();
        return $menuitems;
    }
}