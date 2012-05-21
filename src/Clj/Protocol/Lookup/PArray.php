<?php

namespace Clj\Protocol\Lookup;

class PArray extends \Clj\AProtocolInstance implements \Clj\Protocol\ILookup
{
    public function get($context, $key, $default = null)
    {
        if (isset($context[$key]) || (array_key_exists($key, $context)))
        {
            return $context[$key];
        }
        return $default;
    }

    public function exists($context, $key)
    {
        return (isset($context[$key]) || (array_key_exists($key, $context)));
    }
}
