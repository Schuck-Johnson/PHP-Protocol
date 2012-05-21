<?php

namespace Clj\Protocol\Lookup;

class PNull extends \Clj\AProtocolInstance implements \Clj\Protocol\ILookup
{
    public function get($context, $key, $default = null)
    {
        return $default;
    }

    public function exists($context, $key)
    {
        return false;
    }
}
