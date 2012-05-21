<?php

namespace Clj\Test;

class Protocol extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException BadMethodCallException
     */
    public function testProtocolPersistent()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $lookup->__extend__(\Clj\IProtocol::PROTOCOL_NULL, new \Clj\Protocol\Lookup\PNull());
        $new_var = $lookup->get(null, 'foo', 'bar');
    }
    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidProtocolInstance()
    {
        $to_array = new \Clj\Protocol\ToArray('Clj\\Protocol\\IToArray');
        $null_lookup = new \Clj\Protocol\Lookup\PNull();
        $new_to_array = $to_array->__extend__(\Clj\IProtocol::PROTOCOL_NULL, $null_lookup);
    }
    
    public function testExtend()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $new_lookup = $lookup->__extend__(\Clj\IProtocol::PROTOCOL_NULL, new \Clj\Protocol\Lookup\PNull());
        $this->assertEquals($new_lookup->get(null, 'foo', 'bar'), 'bar');
    }
    
    public function testMetadata()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $lookup = $lookup->__extend__(\Clj\IProtocol::PROTOCOL_NULL, new \Clj\Protocol\Lookup\PNull());
        $lookup = $lookup->__extend__(\Clj\IProtocol::PROTOCOL_ARRAY, new \Clj\Protocol\Lookup\PArray());
        $this->assertEquals($lookup->__types__(), array(\Clj\IProtocol::PROTOCOL_NULL, \Clj\IProtocol::PROTOCOL_ARRAY));
        $this->assertTrue($lookup->__hasType__(\Clj\IProtocol::PROTOCOL_NULL));
        $this->assertFalse($lookup->__hasType__(\Clj\IProtocol::PROTOCOL_OBJECT));
    }
}
