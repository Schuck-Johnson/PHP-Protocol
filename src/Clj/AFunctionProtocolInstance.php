<?php

namespace Clj;
/**
 * Base implementation of a protocol for a type that implements methods using anonymous functions
 */
class AFunctionProtocolInstance implements IProtocolInstance
{
    /**
     * Collection of functions that will implement the protocol 
     * @access protected
     * @var array
     */
    protected $_functions;
    /**
     * Defines the a protocol with  context 
     * @param mixed $functions 
     */
    public function __construct(array $functions = array())
    {
        $this->_functions = $functions;
    }
}
