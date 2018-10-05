<?php

/**
 * Created by PhpStorm.
 * User: Dalton Whyte
 */

class MenuItem
{
    // Class Variables/Properties
    protected $name;
    protected $allergies;
    protected $noticePeriod;

    // Start Setters and Getters
    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setAllergies($allergies) {
        $this->allergies = $allergies;
    }

    public function getAllergies() {
        return $this->allergies;
    }

    public function setNoticePeriod($noticePeriod) {
        $this->noticePeriod = $noticePeriod;
    }

    public function getNoticePeriod() {
        return $this->noticePeriod;
    }
    // End Setters and Getters
}