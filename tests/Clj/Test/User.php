<?php

namespace Clj\Test;

class User extends \Clj\AValueObject
{
    protected $name;
    protected $password;

    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }
}
