<?php
/**
 * Created by PhpStorm.
 * User: Dalton Whyte
 */
class Order
{
    // Class Variables/Properties
    protected $vendorfile;
    protected $day;
    protected $time;
    protected $location;
    protected $covers; //headCount

    // We will be using flat files for vendor data
    // They are stored under the Data directory
    protected $data_dir = __DIR__ . "/../Data/";

    // Start Setters and Getters
    public function setVendorFile($vendorfile) {
        $this->vendorfile = $vendorfile;
    }

    // Set and Get name of vendor data file in Data folder
    public function getVendorFile() {
        return $this->vendorfile;
    }

    // Set and Get delivery date in format (dd/mm/yy)
    public function setDay($day) {
        $this->day = $day;
    }

    public function getDay() {
        return $this->day;
    }

    // Set and Get delivery time in format (hh:mm)
    public function setTime($time) {
        $this->time = $time;
    }

    public function getTime() {
        return $this->time;
    }

    // Set and Get location eg. NW43QB
    public function setLocation($location) {
        $this->location = $location;
    }

    public function getLocation() {
        return $this->location;
    }

    // Set and Get number of people to feed
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
        if(!$this->vendorfile || !$this->day ||  !$this->time
            ||  !$this->location || !$this->covers) {
            print("Please provide the following information to complete an order:
                        Vendor Input File, Day, Time, Location, Covers\r\n");
            return null;
        } else {
            // Open the vendor data file
            $file = fopen($this->data_dir.$this->vendorfile,"r");

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
                    $vendorLocationRegion = (!is_numeric(substr($vendorData[1], 1, 1))) ?
                        substr($vendorData[1], 0, 2) : substr($vendorData[1], 0, 1) ;

                    // Set both locations to uppercase for correct comparison
                    $vendorLocationRegion = strtoupper($vendorLocationRegion);
                    $this->location = strtoupper($this->location);

                    // Compare location given and vendor locations
                    if((strlen($vendorLocationRegion) == 1) && $vendorLocationRegion != substr($this->location, 0, 1)){
                        continue;
                    }
                    else if((strlen($vendorLocationRegion) == 2) && $vendorLocationRegion != substr($this->location, 0, 2)){
                        continue;
                    }

                    // Check if vendor can meet up the order's
                    // covers or head counts
                    else if (intval($vendorData[2]) < intval($this->covers)){
                        continue;
                    } else {
                        // Add to suitable vendor to result list
                        $currVendor = $line;
                        $vendorFound = true;
                    }
                }
                else{
                    // Clear menuitem list
                    $currItems = array();
                    // Get delivery time by subtracting search time
                    $deliveryDateTime = DateTime::createFromFormat("d/m/y H:i", $this->day.' '.$this->time);
                    $searchDateTime = DateTime::createFromFormat("d/m/y H:i:s", date('d/m/y H:i:s'));
                    if($searchDateTime < $deliveryDateTime) {
                        $diff = $deliveryDateTime->diff($searchDateTime);
                        $deliveryTime = ($diff->days * 24) + $diff->h;

                        // Check if menu item notice period
                        // falls within the requested delivery time
                        $menuData = explode(";",$line);
                        if(intval(substr($menuData[2], 0, 2)) <= intval($deliveryTime)){
                            // Add suitable menuitem to result list
                            $currItems[] = $line;
                        }
                    } else {
                        print("Delivery time cannot be before search time!\r\n");
                        return null;
                    }
                }
            }
            // Close vendor text file
            fclose($file);

            // Count the vendors
            $numVendors = count($vendors);
            if($numVendors == 0) {
                print("No vendors defined in input file!\r\n");
                return null;
            }

            // Print the result of valid menuitems
            // Stripping out the notice period
            $menuItems = array();
            foreach ($vendors as $vendor) {
                foreach($vendor as $menuItem){
                    $pickedMenuItem = substr($menuItem, 0, strripos($menuItem, ';')+1);
                    $menuItems[] = $pickedMenuItem;
                }
            }

            // Encode result as JSON response
            return json_encode($menuItems);
        }
    }
}