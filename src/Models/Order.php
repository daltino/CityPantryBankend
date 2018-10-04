<?php
/**
 * Created by PhpStorm.
 * User: angelpilot5
 * Date: 10/4/18
 * Time: 2:10 AM
 */
class Order
{
    // Class Variables/Properties
    protected $vendorfile;
    protected $day;
    protected $time;
    protected $location;
    protected $covers; //headCount

    // Start Setters and Getters
    public function setVendorFile($vendorfile) {
        $this->vendorfile = $vendorfile;
    }

    public function getVendorFile() {
        return $this->vendorfile;
    }

    public function setDay($day) {
        $this->day = $day;
    }

    public function getDay() {
        return $this->day;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function getTime() {
        return $this->time;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setCovers($covers) {
        $this->covers = $covers;
    }

    public function getCovers() {
        return $this->covers;
    }
    // End Setters and Getters

    /*
     * Provides a list of menu items and
     * their respective allergensb based
     * on a defined set of rules.
     */
    public function searchForMenuItems() {
        // Add guards to ensure that needed
        // properties are defined such as
        // input file, day, time, location and
        // covers.
        if(!$this->filename || !$this->day ||  !$this->time
            ||  !$this->location || !$this->covers) {
            print("Please provide the following information to complete an order:
                        Vendor Input File, Day, Time, Location, Covers");
            return null;
        } else {
            // Open the vendor data file
            $file = fopen($this->vendorfile,"r");

            // Set data object and flags to help
            // read the file and store data
            $vendors = array();
            $currVendor = "";
            $currItems = array();
            $vendorFound = false;
            while(! feof($file))
            {
                // Get lines and check if its empty
                $line = trim(fgets($file));
                if($line == "") {
                    $vendors[$currVendor] = $currItems;
                    $vendorFound = false;
                }
                else if(!$vendorFound){
                    // Split vendor string and check if
                    // vendor's location matches with order
                    // Ex. an order with NW43QB matches vendor
                    // with location NW42QA as both starts
                    // with NW.
                    $vendorData = explode(";", $line);
                    if(substr($vendorData[1], 0, 1) != substr($this->location, 0, 1)){
                        continue;
                    }
                    // Check if vendor can meet up the order's
                    // covers or head counts
                    else if ($vendorData[2] < $this->covers){
                        continue;
                    } else {
                        $currVendor = $line;
                        $vendorFound = true;
                    }
                }
                else{
                    // Get delivery time by subtracting search time
                    $deliveryDateTime = strtoupper($this->day.' '.$this->time);
                    $searchDateTime = new DateTime("d/m/y H:i:s");
                    if($searchDateTime < $deliveryDateTime) {
                        $deliveryTime = $deliveryDateTime->diff($searchDateTime)->h;

                        // Check if menu item notice period
                        // falls within the requested delivery time
                        $menuData = explode(";",$line);
                        if(int(substr($menuData, 0, 1)) <= int($deliveryTime)){
                            $currItems[] = $line;
                        }
                    } else {
                        print("Delivery time cannot be before search time!");
                        return null;
                    }
                }
            }
            // Close vendor text file
            fclose($file);

            // Count the vendors
            $numVendors = count($vendors);
            if($numVendors == 0) {
                print("No vendors defined in input file!");
                return null;
            }


        }
    }
}