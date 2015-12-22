<?php

namespace Fuel\Tasks;

class Base
{

	public function __construct()
	{
		\Config::load('base');
		\Cli::write(get_class() . ' START');
	}

	public function __destruct()
	{
		\Cli::write(get_class() . ' FINISH');
	}

}
