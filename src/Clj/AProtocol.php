<?php

namespace Clj;
/**
 * Base implementation of a protocol to be extended to concrete implementations.
 */
class AProtocol implements IProtocol
{
    /**
     * The interface the protocol implements
     * @access protected
     * @var string
     */
    protected $_interface;
    /**
     * An array of concrete protocol implementations with their types as keys
     * @access protected
     * @var array
     */
    protected $_objects;
    /**
     * The derived types from a base type of an php object
     * @access protected
     * @var array
     */
    protected $_derived_types;

    /**
     * List of all the primitive php types
     * @access protected 
     * @var array
     */
    private static $_primitive_types = array(self::PROTOCOL_NULL => true, self::PROTOCOL_ARRAY => true, 
        self::PROTOCOL_OBJECT => true, self::PROTOCOL_STRING => true, self::PROTOCOL_INTEGER => true,
        self::PROTOCOL_FLOAT => true, self::PROTOCOL_NUMBER => true, self::PROTOCOL_BOOLEAN => true);

    /**
     * Sets the interface for the protocol
     * @param string $interface: The name of the interface for the protocol
     * @param bool $autoload: Flag for autoloading the interface
     * @param array $objects: A list of concrete protocol implememtations indexed by type
     * @param array $derived_types: A list of derived types mapping types access by the protocol to
     * the types held by the protocol  
     * @throws \InvalidArgumentException
     */
    public function __construct($interface, $objects = array(), $derived_types = array())
    {
        $clean_interface = trim($interface);
        if (! interface_exists($clean_interface, true))
        {
            throw new \InvalidArgumentException("The interface '{$clean_interface}' was not found");
        }        
        $this->_interface = $clean_interface;
        $this->_objects = $objects;
        $this->_derived_types = $derived_types;
    }
    /**
     * Gets the interface for the protocol is using
     * @return string
     */
    public function __getInterface__()
    {
        return $this->_interface;
    }
    /**
     * Gets the type of a php variable
     * @param mixed $object The php variable we are getting the type for
     * @return string
     */
    public function __getType__($object)
    {
        $php_type = gettype($object);
        if ($php_type === 'object')
        {
            return get_class($object);
        }
        return $php_type;
    }
    /**
     * Gets any derived types of a base type
     * @param string $base_type The name of the base type of a php varible
     * @return string
     */
    private function _getDerivedTypes($base_type)
    {
        if (! (class_exists($base_type, false) || (interface_exists($base_type, false))))
        {
            if (($base_type === self::PROTOCOL_FLOAT) || ($base_type === self::PROTOCOL_INTEGER))
            {
                return self::PROTOCOL_NUMBER;
            }
            return $base_type;
        }
        $parents = class_parents($base_type, false);
        if ($parents)
        {
            foreach($parents as $parent_name)
            {
                if (isset($this->_objects[$parent_name]))
                {
                    return $parent_name;
                }
            }
        }

        $interfaces = class_implements($base_type, false);
        if ($interfaces)
        {
            foreach($interfaces as $interface_name)
            {
                if (isset($this->_objects[$interface_name]))
                {
                    return $interface_name;
                }
            }
        }

        return self::PROTOCOL_OBJECT;
    }
    /**
     * Cleans up the type name given by the user
     * @param string $type_name The user inputted type name
     * @return string
     */
    private function _getCleanTypeName($type_name)
    {
        $clean_name = trim($type_name);
        $primitive_name = strtolower($clean_name); 
        if (isset(self::$_primitive_types[$primitive_name]))
        {
            if ($primitive_name === self::PROTOCOL_NULL)
            {
                return 'NULL';
            }
            if ($primitive_name === self::PROTOCOL_FLOAT)
            {
                return 'double';
            }
            return $primitive_name;
        }
        return $clean_name;
    }
    /**
     * Checks if the type and cleans up the type name
     * @param string $type The name of the type
     * @return string
     * @throw \InvalidArgumentException
     */
    private function _validType($type)
    {
        $clean_type = $this->_getCleanTypeName($type);
        if (isset(self::$_primitive_types[$clean_type]))
        {
            return $clean_type;
        }
        if (('NULL' === $clean_type) || ('double' === $clean_type))
        {
            return $clean_type;
        }
        if (! ((interface_exists($clean_type, true)) || (class_exists($clean_type, true))))
        {
            throw new \InvalidArgumentException("There is no interface or class with the name '{$type}'");
        }

        return $clean_type; 
    }
    /**
     * Gets the concrete implementation of the protocol for an object
     * @param mixed $object The object the protocol method is 
     * @return \Clj\IProtocolInstance
     * @throws \BadMethodCallException
     */
    public function __getObject__($object)
    {
        $base_type = $this->__getType__($object);
        if (isset($this->_objects[$base_type]))
        {
            return $this->_objects[$base_type];
        }

        $derived_type = $this->_getDerivedTypes($base_type);
        $this->_derived_types[$derived_type] = $base_type;

        if (isset($this->_objects[$derived_type]))
        {
            $this->_objects[$base_type] =& $this->_objects[$derived_type];
            return $this->_objects[$derived_type];
        }

        $type_name = $base_type;
        if ($base_type === 'NULL')
        {
            $type_name = self::PROTOCOL_NULL;
        }
        if ($base_type === 'double')
        {
            $type_name = self::PROTOCOL_FLOAT;
        } 
        throw new \BadMethodCallException("The type '{$type_name}' has not been extended for protocol '{$this->_interface}'");  
    }
    /**
     * Extends the protocol to a type
     * @param string $type The type we are extending the protocol to
     * @throws \InvalidArgumentException
     * @return \Clj\IProtocol
     * @throw \InvalidArgumentException
     */
    public function __extend__($type, IProtocolInstance $object)
    {
        if (! ($object instanceof $this->_interface))
        {
            $class_name = get_class($object);
            throw new \InvalidArgumentException("The protocol instance '{$class_name}' does not implement the interface '{$this->_interface}'");
        }
        $clean_type = $this->_validType($this->_getCleanTypeName($type));
        $new_objects = array($clean_type => $object);
        if (isset($this->_derived_types[$clean_type]))
        {
            $base_object = $this->_objects[$clean_type];
            $base_type = $this->_derived_types[$clean_type];
            $new_objects[$base_type] = $base_object;
        }
        else if (isset($this->_objects[$type]))
        {
            throw new \InvalidArgumentException("The type '{$type}' has already been defined for protocol '{$class_name}'");
        }

        return new $this($this->_interface, array_merge($this->_objects, $new_objects), $this->_derived_types);
    }
    /**
     * Gets the list of all types that have this protocol
     * @return array
     */
    public function __types__()
    {
        $type_map = array('NULL' => self::PROTOCOL_NULL, 'double' => self::PROTOCOL_FLOAT);
        return array_map(function($type) use ($type_map) {
            return isset($type_map[$type]) ? $type_map[$type] : $type;
        }, array_keys($this->_objects));
    }
    /**
     * Checks if the protocol is implemented for this type
     * @param string $type: The name of the type to check for
     * @return bool
     */
    public function __hasType__($type)
    {
        return isset($this->_objects[$this->_getCleanTypeName($type)]);
    }
}
