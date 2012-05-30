<?php

$loader = require __DIR__ . '/../src/bootstrap.php';
$loader->add('Sample', __DIR__);

$protocol_manager = \Sample\Manager::getManager();
$lookup = new \Clj\Protocol\Lookup('Clj\\Protocol\\ILookup');
$protocol_manager->add($lookup);

$protocol_types = array(
    \Clj\IProtocol::PROTOCOL_NULL => new \Clj\Protocol\Lookup\PNull(),
    \Clj\IProtocol::PROTOCOL_ARRAY => new \Clj\Protocol\Lookup\PArray(),
    'Clj\\IValueObject' => new \Clj\Protocol\Lookup\PValueObject() 
);
$protocol_manager->extendProtocol('Clj\\Protocol\\ILookup', $protocol_types);



$fn = new \Clj\Protocol\Fn('Clj\\Protocol\\IFn');
$protocol_manager->add($fn);
$lookup_ref = $protocol_manager->getProtocolReference('Clj\\Protocol\\ILookup');
$fn_extends = array('Closure' => new \Clj\Protocol\Fn\PClosure(),
    'Sample\Curl' => new \Sample\Protocol\Fn\PCurl($lookup_ref),
    'Sample\\RegexMatch' => new \Sample\Protocol\Fn\PRegexMatch($lookup_ref)
);

$protocol_manager->extendProtocol('Clj\\Protocol\\IFn', $fn_extends);
function fn($context, array $parameters = array())
{
    static $fn_ref;
    if (! isset($fn_ref))
    {
        $fn_ref = \Sample\Manager::getManager()->getProtocolReference('Clj\\Protocol\\IFn');
    }

    return $fn_ref->getRef()->fn($context, $parameters);
}

$regex = '/doe|dow/';
$regex_match = new \Sample\RegexMatch('/doe|dow/');
$word = 'downer';
if(fn($regex_match, array($word)))
{
    echo "Regex: '{$regex}' matched '{$word}'." . PHP_EOL;
}
else
{
    echo "Regex: '{$regex}' did not match '{$word}'." . PHP_EOL;
}

$url = 'www.google.com';
$curl = new \Sample\Curl($url);
$response = fn($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_CONNECTTIMEOUT => 3, 'return_error' => true));
if ($lookup_ref->getRef()->get($response, 'code', 0) === 0)
{
    echo "Curl to '{$url}' was successful" . PHP_EOL;
}
else
{
    echo "Curl to '{$url}' was unsuccessful" . PHP_EOL;
}
