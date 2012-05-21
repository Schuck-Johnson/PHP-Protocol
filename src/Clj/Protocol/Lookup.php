<?php

namespace Clj\Protocol;

class Lookup extends \Clj\AProtocol
{
    public function get($object, $key, $default = null)
    {
        return $this->__getObject__($object)->get($object, $key, $default);
    }

    public function exists($object, $key)
    {
        return $this->__getObject__($object)->exists($object, $key);
    }
}
