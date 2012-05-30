<?php

namespace Sample\Protocol\Lookup;

class PCurrentUser extends \Clj\AProtocolInstance implements \Clj\Protocol\ILookup
{
    public function get($context, $key, $default = null)
    {
        $method_name = 'get' . str_replace('_', '', $key);
        if (method_exists($context, $method_name))
        {
            return $context->{$method_name}();
        }
        if (method_exists($this, $method_name))
        {
            return $this->{$method_name}($context);
        }
        return $default;
    }

    public function exists($context, $key)
    {
        $method_name = 'get' . str_replace('_', '', $key);
        return (method_exists($context, $method_name));
    }

    private function getName($context)
    {
        return implode(' ', array(\get($context, 'first_name', ''), \get($context, 'last_name', '')));
    }
}
