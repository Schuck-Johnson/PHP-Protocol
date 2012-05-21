<?php

namespace Clj\Test;

class ProtocolManager extends \PHPUnit_Framework_TestCase
{
    protected $_protocol_manager;

    public function setUp()
    {
        $this->_protocol_manager = new \Clj\ProtocolManager();

        $null_lookup = new \Clj\Protocol\Lookup\PNull();
        $null_toarray = new \Clj\Protocol\ToArray\PNull();
    }

    public function testMetadata()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $to_array = new \Clj\Protocol\ToArray('Clj\\Protocol\\IToArray');
        $this->_protocol_manager->add($lookup);
        $this->_protocol_manager->add($to_array);
        $this->assertEquals($this->_protocol_manager->getProtocolNames(), array('Clj\\Protocol\\ILookup', 'Clj\\Protocol\\IToArray'));
        $this->assertTrue($this->_protocol_manager->hasProtocol('Clj\\Protocol\\ILookup'));
        $this->assertfalse($this->_protocol_manager->hasProtocol('Clj\\Protocol\\ITimestamp'));
    }

    public function testProtocolReference()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $this->_protocol_manager->add($lookup);

        $lookup_ref = $this->_protocol_manager->getProtocolReference('Clj\\Protocol\\ILookup');
        $this->_protocol_manager->extendProtocol('Clj\\Protocol\\ILookup', array(\Clj\IProtocol::PROTOCOL_ARRAY => new \Clj\Protocol\Lookup\PArray(),
        \Clj\IProtocol::PROTOCOL_NULL => new \Clj\Protocol\Lookup\PNull()));
        $lookup = $lookup_ref->getRef();

        $this->assertEquals($lookup->get(array('foo' => 2), 'foo', 1), 2);
        $this->assertEquals($lookup->get(null, 'foo', 1), 1);
    }

    public function testExtendType()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $this->_protocol_manager->add($lookup);

        $this->_protocol_manager->extendType(\Clj\IProtocol::PROTOCOL_ARRAY, array('Clj\\Protocol\\ILookup' => new \Clj\Protocol\Lookup\PArray()));
        $new_lookup = $this->_protocol_manager->getProtocol('Clj\\Protocol\\ILookup');

        $this->assertEquals($new_lookup->get(array('foo' => 2), 'foo', 1), 2);
    }

    public function testExtendProtocol()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $this->_protocol_manager->add($lookup);

        $this->_protocol_manager->extendProtocol('Clj\\Protocol\\ILookup', array(\Clj\IProtocol::PROTOCOL_ARRAY => new \Clj\Protocol\Lookup\PArray()));
        $new_lookup = $this->_protocol_manager->getProtocol('Clj\\Protocol\\ILookup');

        $this->assertEquals($new_lookup->get(array('foo' => 2), 'foo', 1), 2);
    } 
    /**
     * @expectedException BadMethodCallException
     */
    public function testProtocol()
    {
        $lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
        $this->_protocol_manager->add($lookup);

        $this->_protocol_manager->extendProtocol('Clj\\Protocol\\ILookup', array(\Clj\IProtocol::PROTOCOL_ARRAY => new \Clj\Protocol\Lookup\PArray()));
        $new_lookup = $this->_protocol_manager->getProtocol('Clj\\Protocol\\ILookup');
        $this->_protocol_manager->extendProtocol('Clj\\Protocol\\ILookup', array(\Clj\IProtocol::PROTOCOL_NULL => new \Clj\Protocol\Lookup\PNull()));

        $this->assertEquals($new_lookup->get(array('foo' => 2), 'foo', 1), 2);
        $this->assertEquals($lookup->get(null, 'foo', 1), 1);
    }

}
