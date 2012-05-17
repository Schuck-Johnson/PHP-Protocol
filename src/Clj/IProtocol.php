<?php

namespace Clj;
/**
 * Interface for the container of the concrete implementations of protocol 
 */
interface IProtocol
{
    /**
     * The primitive php types 
     */
    const PROTOCOL_NULL = 'null';
    const PROTOCOL_ARRAY = 'array';
    const PROTOCOL_OBJECT = 'object';
    const PROTOCOL_STRING = 'string';
    const PROTOCOL_INTEGER = 'integer';
    const PROTOCOL_FLOAT = 'float';
    const PROTOCOL_NUMBER = '*number*';
    const PROTOCOL_BOOLEAN = 'boolean';
    /**
     * Gets the interface for the protocol is using
     * @return string
     */
    public function __getInterface__();
    /**
     * Extends the protocol to a type
     * @param string $type The type we are extending the protocol for
     * @param \Clj\IProtocolInstance $object The concete implementation of the protocol
     * @return \Clj\IProtocolInstance
     */
    public function __extend__($type, IProtocolInstance $object);
    /**
     * Gets the concrete implementation of the protocol for an object
     * @param mixed $object The object the protocol method is 
     * @return \Clj\IProtocolInstance
     * @throws \BadMethodCallException
     */
    public function __getObject__($object);
    /**
     * Gets the type of a php variable
     * @param mixed $object The variable whose type iis needed 
     * @return string
     */
    public function __getType__($object);
    /**
     * Gets the list of all types that have this protocol
     * @return array
     */
    public function __types__();
    /**
     * Checks if the protocol is implemented for this type
     * @param string $type: The name of the type to check for
     * @return bool
     */
    public function __hasType__($type);
}
