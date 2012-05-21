<?php

namespace Clj\Protocol\Timestamp;

class PString extends \Clj\AProtocolInstance implements \Clj\Protocol\ITimestamp
{
    public function timestamp($object)
    {
        $timestamp = strtotime($object);
        if ($timestamp === false)
        {
            throw new \InvalidArgumentException("The string '{$object}' can not be converted to a timestamp");
        }
        return $timestamp;
    }
}
