<?php

namespace Sample;

class ErrorResponse extends \Clj\AValueObject
{
    protected $value;
    protected $code;
    protected $message;
    public function __construct($value, $code, $message)
    {
        $this->value = $value;
        $this->code = $code;
        $this->message = $message;
    }
}
