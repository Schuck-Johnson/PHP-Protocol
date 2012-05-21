<?php

namespace Clj\Protocol;

class Timestamp extends \Clj\AProtocol
{
    public function timestamp($object)
    {
        return $this->__getObject__($object)->timestamp($object);
    }
}
