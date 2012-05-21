<?php

namespace Clj\Protocol;

class ToArray extends \Clj\AProtocol
{
    public function toArray($object)
    {
        return $this->__getObject__($object)->toArray($object);
    }
}
