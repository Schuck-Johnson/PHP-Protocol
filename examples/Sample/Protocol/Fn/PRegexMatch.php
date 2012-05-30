<?php

namespace Sample\Protocol\Fn;

class PRegexMatch extends \Clj\AProtocolInstance implements \Clj\Protocol\IFn
{
    protected $lookup_ref;

    public function __construct($lookup_ref)
    {
        $this->lookup_ref = $lookup_ref;
    }

    public function fn($context, array $parameters = array())
    {
        $regex = $this->lookup_ref->getRef()->get($context, 'regex');
        $match_string = $parameters[0];
        return (bool) preg_match($regex, $match_string);
    }
}
