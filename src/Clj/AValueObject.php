<?php

namespace Clj;
/**
 * Base class for php value objects
 */
class AValueObject implements IValueObject
{
    /**
     * Retrieves a object property
     * @param strng $name: The name of the object property to access
     * @param mixed $default: The default to be used if the property is not found
     * @return mixed
     */
    public function __get__($name, $default = null)
    {
        if (property_exists($this, $name))
        {
            return $this->$name;
        }

        return $default;
    }
    /**
     * Checks if an object property exists
     * @param strng $name: The name of the object property to check
     * @return bool
     */
    public function __exists__($name)
    {
        return property_exists($this, $name);
    }
    /**
     * Converts the object properties to an array
     * @return array
     */
    public function __toArray__()
    {
        return get_object_vars($this);
    }
}
