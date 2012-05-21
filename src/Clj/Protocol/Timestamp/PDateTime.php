<?php

namespace Clj\Protocol\Timestamp;

class PDateTime extends \Clj\AProtocolInstance implements \Clj\Protocol\ITimestamp
{
    public function timestamp($object)
    {
        return $object->getTimestamp();
    }
}
