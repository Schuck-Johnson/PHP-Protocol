<?php

namespace Clj\Test\Protocol;

class Timestamp extends \PHPUnit_Framework_TestCase
{
    public function testNumber()
    {
        $number_timestamp = new \Clj\Protocol\Timestamp\PNumber();
        $timestamp = new \Clj\Protocol\Timestamp('Clj\\Protocol\\ITimestamp');
        $new_timestap = $timestamp->__extend__(\Clj\IProtocol::PROTOCOL_NUMBER, $number_timestamp);
        $unix_timestamp = time();
        $this->assertEquals($new_timestap->timestamp($unix_timestamp), $unix_timestamp);
    }
    
    public function testDateTime()
    {
        $date_time_timestamp = new \Clj\Protocol\Timestamp\PDateTime();
        $timestamp = new \Clj\Protocol\Timestamp('Clj\\Protocol\\ITimestamp');
        $new_timestap = $timestamp->__extend__('DateTime', $date_time_timestamp);
        $time = new \DateTime('now', new \DateTimeZone('Antarctica/Davis'));
        $this->assertEquals($new_timestap->timestamp($time), $time->getTimestamp());
    }

    public function testString()
    {
        $string_timestamp = new \Clj\Protocol\Timestamp\PString();
        $timestamp = new \Clj\Protocol\Timestamp('Clj\\Protocol\\ITimestamp');
        $new_timestap = $timestamp->__extend__(\Clj\IProtocol::PROTOCOL_STRING, $string_timestamp);
        $time = "01-Jan-2001";
        $this->assertEquals($new_timestap->timestamp($time), 978328800);
    }
}
