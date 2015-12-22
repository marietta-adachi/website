<?php

class DaException extends Exception
{

    public function __construct($message, $code = 0, Exception $previous = null)
    {
	parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
	return __CLASS__.": [{$this->code}]: {$this->message}\n";
    }

    public function customFunction()
    {
	echo "A Custom function for this type of exception\n";
    }

}

class FormException extends Exception
{

    public function __construct($message, $code = 0, Exception $previous = null)
    {
	parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
	return __CLASS__.": [{$this->code}]: {$this->message}\n";
    }

    public function customFunction()
    {
	echo "A Custom function for this type of exception\n";
    }

}
