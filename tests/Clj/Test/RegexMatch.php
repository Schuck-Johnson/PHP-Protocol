<?php

namespace Clj\Test;

class RegexMatch extends \Clj\AValueObject
{
    protected $regex;

    public function __construct($regex)
    {
        $this->regex = $regex;
    }
}
