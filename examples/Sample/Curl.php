<?php

namespace Sample;

class Curl extends \Clj\AValueObject
{
    protected $url;
    public function __construct($url)
    {
        $this->url = $url;
    }
}
