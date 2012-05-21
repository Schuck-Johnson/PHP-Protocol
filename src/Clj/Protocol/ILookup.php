<?php

namespace Clj\Protocol;
/**
 * Protocol to retrive properties and see if they exist
 */
interface ILookup
{
    /**
     * Gets a property of a php variable or a default if there is no property
     * @param mixed $context The variabe the protocol is operating on
     * @param mixed $key The key of the property to look for 
     * @param mixed $default The default to return of the key isn't found
     * @return mixed
     */
    public function get($context, $key, $default = null);
    /**
     * Checks if a php variable contains a property
     * @param mixed $context The variabe the protocol is operating on
     * @param mixed $key The key of the property to check for
     * @return bool
     */
    public function exists($context, $key);
}
