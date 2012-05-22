<?php

namespace Clj\Protocol;

class Fn extends \Clj\AProtocol
{
    public function fn($object, array $parameters = array())
    {
        return $this->__getObject__($object)->fn($object, $parameters);
    }
}
