<?php

namespace Clj\Protocol;
/**
 * Protocol to convert a variable to an array
 */
interface IToArray
{
    /**
     * Converts a variable to an array with the properties as keys of the array
     * @param mixed $context The variabe the protocol is operating on
     * @return array
     */
    public function toArray($context);
}
