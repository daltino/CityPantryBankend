<?php

/**
 * Created by PhpStorm.
 * User: Dalton Whyte
 */
class Vendor
{
    // Class Variables/Properties
    protected $name;
    protected $postCode;
    protected $maxHeadCount;

    // Start Setters and Getters
    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setPostCode($postCode) {
        $this->postCode = $postCode;
    }

    public function getPostCode() {
        return $this->postCode;
    }

    public function setMaxHeadCount($maxHeadCount) {
        $this->maxHeadCount = $maxHeadCount;
    }

    public function getMaxHeadCount() {
        return $this->maxHeadCount;
    }
    // End Setters and Getters

}