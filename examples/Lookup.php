<?php

$loader = require __DIR__ . '/../src/bootstrap.php';
$loader->add('Sample', __DIR__);

$protocol_manager = \Sample\Manager::getManager();
$lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
$protocol_manager->add($lookup);

$protocol_types = array(
    \Clj\IProtocol::PROTOCOL_NULL => new \Clj\Protocol\Lookup\PNull(),
    \Clj\IProtocol::PROTOCOL_ARRAY => new \Clj\Protocol\Lookup\PArray()
);
$protocol_manager->extendProtocol('Clj\\Protocol\\ILookup', $protocol_types);

function get($context, $key, $default = null)
{
    static $lookup_ref;
    if (! isset($lookup_ref))
    {
        $lookup_ref = \Sample\Manager::getManager()->getProtocolReference('Clj\\Protocol\\ILookup');
    }

    return $lookup_ref->getRef()->get($context, $key, $default);
}

function get_in($context, $keys, $defualt = null)
{
    $sentinel = new \stdClass();
    foreach($keys as $key)
    {
        $value = \get($context, $key, $sentinel);
        if ($value === $sentinel)
        {
            return $defualt;
        }
    }

    return $value;
}

function exists($context, $key)
{
    static $lookup_ref;
    if (! isset($lookup_ref))
    {
        $lookup_ref = \Sample\Manager::getManager()->getProtocolReference('Clj\\Protocol\\ILookup');
    }

    return $lookup_ref->getRef()->exists($context, $key);
} 

$user_array = array('first_name' => 'Phil', 'last_name' => 'Flanagin', 'email' => 'test@exmaple.net');
echo 'First Name: ' . get($user_array, 'first_name', 'Bob') . PHP_EOL;

$deep_array = array('Sol' => array('mercury', 'venus', 'earth' => 'moon', 'mars' => 'phobos'));
echo 'Jupiters Moons: ' . get_in($deep_array, array('Sol', 'Jupiter'), 'N/A') . PHP_EOL;

$protocol_manager->extendType('Sample\\CurrentUser', array('Clj\\Protocol\\ILookup' => new \Sample\Protocol\Lookup\PCurrentUser()));
$current_user = new \Sample\CurrentUser('Bob', 'Smith', 'smith@sparkle.net');
echo 'Current User First Name: ' . get($current_user, 'first_name', 'Will') . PHP_EOL;
echo 'Current User Name: ' . get($current_user, 'name', 'Kip Sonj') . PHP_EOL;

$current_lookup = $protocol_manager->getProtocol('Clj\\Protocol\\ILookup');
$protocol_manager->extendType('Sample\\FancyUser', 
    array('Clj\\Protocol\\ILookup' => new \Sample\Protocol\Lookup\PFancyUser($current_lookup)));

$fancy_user = new \Sample\FancyUser('Henry', 'Williamson', 'will@roundtable.gov');
echo 'Fancy User First Name: ' . get($fancy_user, 'first_name', 'Ash') . PHP_EOL;
echo 'Fancy User Name: ' . get($fancy_user, 'name', 'Fancy Pants') . PHP_EOL;
