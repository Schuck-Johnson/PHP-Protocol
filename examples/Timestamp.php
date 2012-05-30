<?php

$loader = require __DIR__ . '/../src/bootstrap.php';
$loader->add('Sample', __DIR__);

$protocol_manager = \Sample\Manager::getManager();
$timestamp = new \Clj\Protocol\Timestamp('Clj\\Protocol\\ITimestamp');
$protocol_manager->add($timestamp);

$protocol_types = array(
    \Clj\IProtocol::PROTOCOL_NUMBER => new \Clj\Protocol\Timestamp\PNumber(),
    'DateTime' => new \Clj\Protocol\Timestamp\PDateTime(),
    \Clj\IProtocol::PROTOCOL_STRING => new \Clj\Protocol\Timestamp\PString()
);
$protocol_manager->extendProtocol('Clj\\Protocol\\ITimestamp', $protocol_types);

function timestamp($context)
{
    static $timestamp_ref;
    if (! isset($timestamp_ref))
    {
        $timestamp_ref = \Sample\Manager::getManager()->getProtocolReference('Clj\\Protocol\\ITimestamp');
    }

    return $timestamp_ref->getRef()->timestamp($context);
}

$dates = array(new DateTime(), '2001-10-17', mktime(0, 0, 0, 7, 1, 2006));
echo 'Unsorted Dates'. PHP_EOL;
foreach($dates as $date)
{
    $date_string = $date;
    if ($date instanceof \DateTime)
    {
        $date_string = $date->format('r');
    }
    echo 'Date: ' . $date_string . PHP_EOL;
}
usort($dates, function($first_date, $second_date) {
    $first_timestamp = \timestamp($first_date);
    $second_timestamp = \timestamp($second_date);
    if ($first_timestamp === $second_timestamp)
    {
        return 0;
    }
    return ($first_timestamp < $second_timestamp) ? -1 : 1;
});

echo 'Sorted Dates'. PHP_EOL;

foreach($dates as $date)
{
    $date_string = $date;
    if ($date instanceof \DateTime)
    {
        $date_string = $date->format('r');
    }
    echo 'Date: ' . $date_string . PHP_EOL;
}
