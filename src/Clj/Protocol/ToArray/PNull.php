<?php

namespace Clj\Protocol\ToArray;

class PNull extends \Clj\AProtocolInstance implements \Clj\Protocol\IToArray
{
    public function toArray($object)
    {
        return array();
    }
}
