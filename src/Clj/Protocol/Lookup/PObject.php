<?php

namespace Clj\Protocol\Lookup;

class PObject extends \Clj\AProtocolInstance implements \Clj\Protocol\ILookup
{
    public function get($context, $key, $default = null)
    {
        if (isset($context->$key))
        {
            return $context->$key;
        }
        return $default;
    }

    public function exists($context, $key)
    {
        return isset($context->$key);
    }
}
