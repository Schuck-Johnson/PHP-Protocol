<?php

namespace Clj;
/**
 * Central object for storage and extension of protocols
 */
class ProtocolManager
{
    /**
     * List of protocols indexed by the interfaces they implement
     * @access private
     * @var array
     */
    private $_protocols;
    /**
     * Initializes the manager protocols to an empty array
     */
    public function __construct()
    {
        $this->_protocols = array();
    }
    /**
     * Adds a protocol to the manager
     * @param \Clj\IProtocol $protocol The protocol to be added to the manager
     * @return \Clj\ProtocolManager
     * @throw \InvalidArgumentException
     */
    public function add(IProtocol $protocol)
    {
        $interface = $protocol->__getInterface__();
        if (isset($this->_protocols[$interface]))
        {
            \InvalidArgumentException("The protocol {$interface} has already added to this protocol manager");
        }
        $this->_protocols[$interface] = $protocol;

        return $this;
    }
    /**
     * Internal method to retrieve the protocol and validate it exists
     * @param string $protocol_name The name of the protocol to be retrieved
     * @return \Clj\IProtocol
     * @throw \OutOfBoundsException
     */
    protected function _getProtocol($protocol_name)
    {
        if (! isset($this->_protocols[$protocol_name]))
        {
            $stored_prococols = "('" . implode("', '", array_keys($this->_protocols)) . "')";
            throw new \OutOfBoundsException("The protocol {$protocol_name} was not found.  The stored procotols are {$stored_prococols}.");
        }

        return $this->_protocols[$protocol_name];
    }
    /**
     * Retrieves a protocol
     * @param string $protocol_name The name of the protocol to be retrieved
     * @return \Clj\IProtocol
     */
    public function getProtocol($protocol_name)
    {
        return $this->_getProtocol($protocol_name);
    }
    /**
     * Retrieves a reference to a protocol
     * @param string $protocol_name The name of the protocol reference to be retrieved
     * @return \Clj\ReadOnlyRef
     */
    public function getProtocolReference($protocol_name)
    {
        $protocol = $this->_getProtocol($protocol_name);
        return new ReadOnlyRef($this->_protocols[$protocol_name]);
    }
    /**
     * Extends several protocols to a type 
     * @param string $type_name The name of the type to be exteneded
     * @param array $protocols List of the concrete protocol implementations indexed
     * by the protocols they are extending
     * @return \Clj\ProtocolManager
     */
    public function extendType($type_name, $protocols)
    {
        foreach($protocols as $protocol_name => $protocol_instance)
        {
            $protocol = $this->_getProtocol($protocol_name);
            $this->_protocols[$protocol_name] = $protocol->__extend__($type_name, $protocol_instance);
        }
        return $this;
    }
    /**
     * Extends a prtoocol to several types
     * @param string $protocol_name The name of the protocol to be extended
     * @param array $protocols List of the concrete protocol implementations indexed
     * by the protocols they are extending
     * @return \Clj\ProtocolManager
     */
    public function extendProtocol($protocol_name, $types)
    {
        $protocol = $this->_getProtocol($protocol_name);
        foreach($types as $type_name => $protocol_instance)
        {
            $protocol = $protocol->__extend__($type_name, $protocol_instance);
        }
        $this->_protocols[$protocol_name] = $protocol;
        return $this;
    }
    /**
     * Check if the manager has a protocol
     * @param string $protocol_name The name of the protocol to be checked
     * @return bool
     */
    public function hasProtocol($protocol_name)
    {
        return isset($this->_protocols[trim($protocol_name)]);
    }
    /**
     * Gets the list of the names of the protocols held by the manager 
     * @return array
     */
    public function getProtocolNames()
    {
        return array_keys($this->_protocols);
    }

}
