<?php

namespace Clj\Test;

class Address
{
    private $street;
    protected $city;
    public $state;

    public function __construct($street, $city, $state)
    {
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
    }
}
