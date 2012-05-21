<?php

namespace Clj\Test;

class Ref extends \PHPUnit_Framework_TestCase
{
    public function testRef()
    {
        $foo = 10;
        $foo_ref = new \Clj\ReadOnlyRef($foo);
        $foo = "bar";
        $this->assertEquals($foo, $foo_ref->getRef());
    }
}
