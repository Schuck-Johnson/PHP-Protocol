<?php

namespace Clj\Test\Protocol;

class ToArray extends \PHPUnit_Framework_TestCase
{
    public function testNull()
    {
        $to_array = new \Clj\Protocol\ToArray('Clj\\Protocol\\IToArray');
        $null_to_array = new \Clj\Protocol\ToArray\PNull();
        $new_to_array = $to_array->__extend__(\Clj\IProtocol::PROTOCOL_NULL, $null_to_array);
        $null = null;
        $this->assertEquals($new_to_array->toArray($null), array());
    }

    public function testArray()
    {
        $to_array = new \Clj\Protocol\ToArray('Clj\\Protocol\\IToArray');
        $array_to_array = new \Clj\Protocol\ToArray\PArray();
        $new_to_array = $to_array->__extend__(\Clj\IProtocol::PROTOCOL_ARRAY, $array_to_array);
        $array = array('name' => 'fred');
        $this->assertEquals($new_to_array->toArray($array), $array);
    }

    public function testTraverseable()
    {
        $to_array = new \Clj\Protocol\ToArray('Clj\\Protocol\\IToArray');
        $traverseable_to_array = new \Clj\Protocol\ToArray\PTraversable();
        $new_to_array = $to_array->__extend__('Traversable', $traverseable_to_array);
        $array = array('name' => 'fred');
        $array_object = new \ArrayObject($array);
        $this->assertEquals($new_to_array->toArray($array_object), $array);
    }
    
    public function testObject()
    {
        $to_array = new \Clj\Protocol\ToArray('Clj\\Protocol\\IToArray');
        $object_to_array = new \Clj\Protocol\ToArray\PObject();
        $new_to_array = $to_array->__extend__(\Clj\IProtocol::PROTOCOL_OBJECT, $object_to_array);
        $address = new \Clj\Test\Address('123 Nowhere', 'Leng', 'Nirvana');
        $address_array = array('street' => '123 Nowhere', 'city' => 'Leng', 'state' => 'Nirvana');
        $this->assertEquals($new_to_array->toArray($address), $address_array);
    }

    public function testValueObject()
    {
        $to_array = new \Clj\Protocol\ToArray('Clj\\Protocol\\IToArray');
        $value_object_to_array = new \Clj\Protocol\ToArray\PValueObject();
        $user = new \Clj\Test\User('fred', 'password');
        $user_array = array('name' => 'fred', 'password' => 'password');
        $new_to_array = $to_array->__extend__('Clj\\IValueObject', $value_object_to_array);
        $this->assertEquals($new_to_array->toArray($user), $user_array);
    }
}
