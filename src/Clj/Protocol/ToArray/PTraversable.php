<?php

namespace Clj\Protocol\ToArray;

class PTraversable extends \Clj\AProtocolInstance implements \Clj\Protocol\IToArray
{
    public function toArray($object)
    {
        return iterator_to_array($object, true);
    }
}
