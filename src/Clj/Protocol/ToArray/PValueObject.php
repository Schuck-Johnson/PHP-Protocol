<?php

namespace Clj\Protocol\ToArray;

class PValueObject extends \Clj\AProtocolInstance implements \Clj\Protocol\IToArray
{
    public function toArray($object)
    {
        return $object->__toArray__();
    }
}
