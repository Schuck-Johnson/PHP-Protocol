<?php

namespace Clj\Protocol;
/**
 * Protocol for calling a context like a function
 */
interface IFn
{
    /**
     * Function call on a context with parameters
     * @param mixed $context The variabe the protocol is operating on
     * @param array $parameters Parameters to be passed into the function context 
     * @return mixed
     */
    public function fn($context, array $parameters = array());
}
