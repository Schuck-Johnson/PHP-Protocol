<?php

namespace Sample\Protocol\Lookup;

class PFancyUser extends \Clj\AProtocolInstance implements \Clj\Protocol\ILookup
{
    private $lookup;
    public function __construct(\Clj\Protocol\Lookup $lookup)
    {
        $this->lookup = $lookup;
    }

    private function getName($context)
    {
        return 'Sir/Madam ' . $this->lookup->get($context, 'name');
    }

    public function get($context, $key, $default = null)
    {
        $method_name = 'get' . str_replace('_', '', $key);
        if (method_exists($this, $method_name))
        {
            return $this->{$method_name}($context);
        }
        return $this->lookup->get($context, $key, $default);
    }

    public function exists($context, $key)
    {
        $method_name = 'get' . str_replace('_', '', $key);
        return ((method_exists($context, $method_name)) || $this->lookup->exists($context, $key));
    }
}
