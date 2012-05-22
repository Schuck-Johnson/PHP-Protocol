<?php

namespace Clj\Protocol\Fn;

class PClosure extends \Clj\AProtocolInstance implements \Clj\Protocol\IFn
{
    public function fn($context, array $parameters = array())
    {
        return call_user_func_array($context, $parameters);
    }
}
