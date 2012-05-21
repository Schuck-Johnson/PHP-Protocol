<?php

namespace Clj\Test\Protocol;

class Lookup extends \PHPUnit_Framework_TestCase
{
    public function testNull()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $null_lookup = new \Clj\Protocol\Lookup\PNull();
        $new_lookup = $lookup->__extend__(\Clj\IProtocol::PROTOCOL_NULL, $null_lookup);
        $null = null;
        $this->assertEquals($new_lookup->get($null, 'name', 'bob'), 'bob');
        $this->assertFalse($new_lookup->exists($null, 'name'));
    }

    public function testArray()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $array_lookup = new \Clj\Protocol\Lookup\PArray();
        $new_lookup = $lookup->__extend__(\Clj\IProtocol::PROTOCOL_ARRAY, $array_lookup);
        $array = array('name' => 'fred');
        $this->assertEquals($new_lookup->get($array, 'name', 'bob'), 'fred');
        $this->assertTrue($new_lookup->exists($array, 'name'));
    }
    
    public function testObject()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $object_lookup = new \Clj\Protocol\Lookup\PObject();
        $new_lookup = $lookup->__extend__(\Clj\IProtocol::PROTOCOL_OBJECT, $object_lookup);
        $user = new \stdClass();
        $user->name = 'fred';
        $this->assertEquals($new_lookup->get($user, 'name', 'bob'), 'fred');
        $this->assertTrue($new_lookup->exists($user, 'name'));
    }

    public function testValueObject()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $value_object_lookup = new \Clj\Protocol\Lookup\PValueObject();
        $user = new \Clj\Test\User('fred', 'password');
        $new_lookup = $lookup->__extend__('Clj\\IValueObject', $value_object_lookup);
        $this->assertEquals($new_lookup->get($user, 'name', 'bob'), 'fred');
        $this->assertTrue($new_lookup->exists($user, 'name'));
    }
}
