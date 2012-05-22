<?php

namespace Clj\Test\Protocol\Fn;

class PRegexMatch extends \Clj\AProtocolInstance implements \Clj\Protocol\IFn
{
    public function fn($context, array $parameters = array())
    {
        $regex = $context->__get__('regex');
        $match_string = $parameters[0];
        return (bool) preg_match($regex, $match_string);
    }
}
