<?php

namespace Clj\Protocol;
/**
 * Protocol for converting php variables to unix timestamps
 */
interface ITimestamp
{
    /**
     * Comverts a variable into a unix timestamp
     * @param mixed $context The variabe the protocol is operating on
     * @return int
     */
    public function timestamp($context);
}
