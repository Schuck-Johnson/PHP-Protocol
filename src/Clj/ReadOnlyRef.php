<?php

namespace Clj;
/**
 * Holds a reference to a variable that can only be read
 */
class ReadOnlyRef implements IRef
{
    /**
     * Reference to an outside variable
     * @access private
     * @var mixed
     */
    private $_reference;
    /**
     * Sets the reference to the outside php variable
     * @param mixed $reference: The referene to the outside php variable
     */
    final public function __construct(&$reference)
    {
        $this->_reference =& $reference;
    }
    /**
     * Get the php variable held by the reference
     * @return mixed
     */
    public function getRef()
    {
        return $this->_reference;
    }
}
