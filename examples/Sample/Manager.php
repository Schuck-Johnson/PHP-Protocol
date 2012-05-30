<?php

namespace Sample;

class Manager
{
    private static $manager;

    public static function getManager()
    {
        if (! isset(self::$manager))
        {
            self::$manager = new \Clj\ProtocolManager();
        }
        return self::$manager;
    }

    final private function __construct()
    {}
}
