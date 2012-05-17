<?php

namespace Clj;
/**
 * Interface for reference holder 
 */
interface IRef
{
    /**
     * Get the php variable held by the reference
     * @return mixed
     */
    public function getRef();
}
