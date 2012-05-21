<?php

namespace Clj\Protocol\ToArray;

class PArray extends \Clj\AProtocolInstance implements \Clj\Protocol\IToArray
{
    public function toArray($object)
    {
        return $object;
    }
}
