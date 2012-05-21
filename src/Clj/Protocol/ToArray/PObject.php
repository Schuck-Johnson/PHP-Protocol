<?php

namespace Clj\Protocol\ToArray;

class PObject extends \Clj\AProtocolInstance implements \Clj\Protocol\IToArray
{
    public function toArray($object)
    {
        $obj_array = array();
        $class_name = get_class($object);
        $name_length = strlen($class_name);
        $null_terminator = chr(0);
        foreach((array) $object as $name => $value)
        {
            $new_name = str_replace($null_terminator, '', $name);
            if (strpos($new_name, $class_name) === 0)
            {
                $obj_array[substr($new_name, $name_length)] = $value;
            }
            else
            {
                $obj_array[ltrim($new_name, '*')] = $value;
            }
        }
        return $obj_array;
    }
}
