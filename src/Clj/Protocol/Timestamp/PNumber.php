<?php

namespace Clj\Protocol\Timestamp;

class PNumber extends \Clj\AProtocolInstance implements \Clj\Protocol\ITimestamp
{
    public function timestamp($object)
    {
        return $object;
    }
}
