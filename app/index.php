<?php
/**
 * Created by PhpStorm.
 * User: Dalton Whyte
 */
error_reporting(E_ALL);
ini_set('display_errors', TRUE); // Error display - OFF in production env or real server
ini_set('log_errors', TRUE); // Error logging
ini_set('error_log', '../logs/errors.log'); // Logging file
ini_set('log_errors_max_len', 1024); // Logging file size

require __DIR__. "/../src/API/OrderAPI.php";

// Get arguments from the terminal
if (count($argv) >= 6){
    $vendorData = $argv[1];
    $deliveryDay = $argv[2];
    $deliveryTime = $argv[3];
    $location = $argv[4];
    $covers = $argv[5];

//    // Initialize the Ordering API
    $orderAPI = new OrderAPI();
    $menuItems = $orderAPI->search($vendorData, $deliveryDay, $deliveryTime, $location, $covers);
    $menuItems = json_decode($menuItems);
    foreach($menuItems as $menuitem){
        print("\e[0;30;43m".$menuitem."\e[0m\r\n");
    }
} else {
    print("\e[0;31;43mPlease provide the following information in the order mentioned: Vendor Data File, Delivery Day, Delivery Time, Location, Covers\e[0m\n");
}