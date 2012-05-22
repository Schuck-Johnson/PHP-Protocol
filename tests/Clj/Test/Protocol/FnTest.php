<?php

namespace Clj\Test\Protocol;

class Fn extends \PHPUnit_Framework_TestCase
{
    public function testClosure()
    {
        $fn = new \Clj\Protocol\Fn('Clj\\Protocol\\IFn');
        $regex_fn = $fn->__extend__('Closure', new \Clj\Protocol\Fn\PClosure());
        $join_strings = function($adjective) { return "{$adjective} cow"; };
        $this->assertEquals($regex_fn->fn($join_strings, array('fast')), 'fast cow');
    }

    public function testRegexMatch()
    {
        $fn = new \Clj\Protocol\Fn('Clj\\Protocol\\IFn');
        $regex_fn = $fn->__extend__('Clj\\Test\\RegexMatch', new \Clj\Test\Protocol\Fn\PRegexMatch());
        $regex_match = new \Clj\Test\RegexMatch('/doe|dow/');
        $this->assertTrue($regex_fn->fn($regex_match, array('downer')));
        $this->assertFalse($regex_fn->fn($regex_match, array('upper')));
    }
}
