<?php

namespace Clj\Protocol\Lookup;

class PValueObject extends \Clj\AProtocolInstance implements \Clj\Protocol\ILookup
{
    public function get($context, $key, $default = null)
    {
        return $context->__get__($key, $default);
    }

    public function exists($context, $key)
    {
        return $context->__exists__($key);
    }
}
